<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Internal;

use DateTime;
use DateTimeZone;
use EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf;
use EntelisTeam\Lbaf\Hydrator\Attribute\Map;
use EntelisTeam\Lbaf\Hydrator\Definition\ArgDefinition;
use EntelisTeam\Lbaf\Hydrator\Definition\ClassDefinition;
use EntelisTeam\Lbaf\Hydrator\Definition\DefinitionType;
use EntelisTeam\Lbaf\Hydrator\Exception\ArgumentTypeException;
use EntelisTeam\Lbaf\Hydrator\Exception\RequiredArgumentException;
use EntelisTeam\Reflection\ClassNameHelper;
use EntelisTeam\Reflection\EnumHelper;
use EntelisTeam\Reflection\TypeCaster;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use ReflectionProperty;
use ReflectionUnionType;
use Throwable;
use ValueError;

/**
 * Известные проблемы
 *  - не работает если есть объединение типов
 * @todo написать свои reflection property/parameter без косяков php
 */
class HydratorEngine
{
    /**
     * @var ClassDefinition[]
     */
    protected static array $definitionCache = [];

    protected static function createClassFromDefinition(ClassDefinition $classDefinition, object $jsonData, bool $skipErrorsInArrayCreation, string $path = '', ?string $source = null): object
    {
        //собираем данные для конструктора
        $constructorArgs = [];
        if (is_array($classDefinition->constructorArgs)) {
            $constructorArgs = self::fillArgs($classDefinition->constructorArgs, $jsonData, $skipErrorsInArrayCreation, $path, $source);
        }

        //создаем класс
        $classInstance = $classDefinition->reflection->newInstanceArgs($constructorArgs);

        //патчим свойства класса
        $properties = self::fillArgs($classDefinition->properties, $jsonData, $skipErrorsInArrayCreation, $path, $source);

        foreach ($properties as $key => $value) {
            if ($classDefinition->properties[$key]->reflection->isReadOnly()) {
                $classDefinition->properties[$key]->reflection->setValue($classInstance, $value);
            } else {
                $classInstance->$key = $value;
            }
        }

        return $classInstance;
    }

    /**
     * @param ArgDefinition[] $params
     */
    protected static function fillArgs(array $params, object $jsonData, bool $skipErrorsInArrayCreation, string $parentPath = '', ?string $source = null): array
    {
        $result = [];

        foreach ($params as $param) {
            $dataKey = self::resolveDataKey($param, $source);
            $errorPath = $parentPath . '->' . $param->title . ($dataKey !== $param->title ? '{' . $dataKey . '}' : '');

            if (!isset($jsonData->{$dataKey})) {
                if ($param->mustBeOverwritten) {
                    throw new RequiredArgumentException($param->reflection, $errorPath);
                }
                $result[$param->title] = $param->defaultValue;
            } else {
                $result[$param->title] = self::extractArgFromData($param, $jsonData->{$dataKey}, $skipErrorsInArrayCreation, $errorPath, $source);
            }
        }
        return $result;
    }

    /**
     * Резолв ключа во входных данных по правилам Map:
     *  - source совпал с одним из Map(...,'X')          → использовать его поле
     *  - есть Map(...,null) и явный source не совпал    → использовать fallback-поле
     *  - иначе                                           → имя свойства/параметра
     */
    protected static function resolveDataKey(ArgDefinition $param, ?string $source): string
    {
        if ($source !== null && isset($param->maps[$source])) {
            return $param->maps[$source];
        }
        if (isset($param->maps[''])) {
            return $param->maps[''];
        }
        return $param->title;
    }

    protected static function extractArgFromData(ArgDefinition $param, mixed $value, bool $skipErrorsInArrayCreation, string $currentPath = '', ?string $source = null)
    {
        switch ($param->definitionType) {
            case DefinitionType::SIMPLE:
                return self::_formatSimple($param->argType, $value);

            case DefinitionType::ENUM:
                try {
                    return EnumHelper::formatEnumValue($param->argType, $value);
                } catch (Throwable $e) {
                    //не смогли найти такой - тут раньше был ValueError но почему-то он не кидается
                    throw new RequiredArgumentException($param->reflection, $currentPath);
                }

            case DefinitionType::OBJECT:
                //@todo говнокодное решение чтобы делать union в свойствах класса
                if (is_array($param->argType)) {
                    $lastClass = end($param->argType);
                    foreach ($param->argType as $targetClass) {
                        try {
                            return self::createClassFromData(
                                $targetClass,
                                is_object($value) ? $value : (object)$value,
                                $skipErrorsInArrayCreation,
                                $currentPath . '(' . ClassNameHelper::getShortClassName($targetClass) . ')',
                                $source
                            );
                        } catch (Throwable $e) {
                            if ($targetClass == $lastClass) {
                                throw $e;
                            }
                            continue;
                        }
                    }
                } else {
                    return self::createClassFromData(
                        $param->argType,
                        is_object($value) ? $value : (object)$value,
                        $skipErrorsInArrayCreation,
                        $currentPath . '(' . ClassNameHelper::getShortClassName($param->argType) . ')',
                        $source
                    );
                }
                // no break — unreachable, switch returns above

            case DefinitionType::ARRAY:
                if (!is_array($value)) {
                    throw new ArgumentTypeException($param->title . " must be an array", $currentPath);
                }
                return self::createArrayFromData($param->argType, $value, $param->reflection, $skipErrorsInArrayCreation, $currentPath, $source);
        }
    }

    protected static function _formatSimple(string $targetType, mixed $value): mixed
    {
        //@todo использовать gettype плохо, он возвращает устаревшие названия (например boolean вместо bool) - нужно везде перейти на reflection
        return (gettype($value) !== 'NULL' && gettype($value) != $targetType) ? TypeCaster::cast($value, $targetType) : $value;
    }

    /**
     * Создает класс из переданных данных.
     * Корректно обрабатывает как переменные конструктора, так и свойства класса
     * (должны быть или публичными или явно поддерживаться через __set).
     * Корректно обрабатывает вложенные классы, enum, массивы.
     * @throws ReflectionException
     */
    public static function createClassFromData(string $className, object $jsonData, bool $skipErrorsInArrayCreation, string $path = '', ?string $source = null): object
    {
        //особые кейсы встроенных классов
        //@todo подумать как сделать красивее
        if ($className === 'DateTime' && !empty($jsonData->scalar)) {
            return new DateTime($jsonData->scalar);
        }
        if ($className === 'DateTime' && !empty($jsonData->date) && !empty($jsonData->timezone)) {
            return new DateTime($jsonData->date, new DateTimeZone($jsonData->timezone));
        }

        if ($path === '') {
            $path = '(' . ClassNameHelper::getShortClassName($className) . ')';
        }

        return self::createClassFromDefinition(
            self::getClassDefinition($className),
            $jsonData,
            $skipErrorsInArrayCreation,
            $path,
            $source
        );
    }

    /**
     * Генерируем определение класса в формате удобном для генерации.
     * Используем кеш.
     */
    protected static function getClassDefinition(string $className): ClassDefinition
    {
        if (isset(self::$definitionCache[$className])) {
            return self::$definitionCache[$className];
        }

        $classReflection = new ReflectionClass($className);
        $result = new ClassDefinition();
        $result->reflection = $classReflection;

        $constructorReflection = $classReflection->getConstructor();
        if ($constructorReflection) {
            $constructorArrayParametersType = [];
            foreach ($constructorReflection->getAttributes(ArrayTypeOf::class, ReflectionAttribute::IS_INSTANCEOF) as $constructorAttribute) {
                /** @var ArrayTypeOf $attribute */
                $attribute = $constructorAttribute->newInstance();
                $constructorArrayParametersType[$attribute->param] = $attribute->targetClass;
            }

            $result->constructorArgs = [];
            foreach ($constructorReflection->getParameters() as $parameterReflection) {
                foreach ($parameterReflection->getAttributes(ArrayTypeOf::class, ReflectionAttribute::IS_INSTANCEOF) as $parameterAttributeReflection) {
                    /** @var \EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf $attribute */
                    $attribute = $parameterAttributeReflection->newInstance();
                    $constructorArrayParametersType[$parameterReflection->getName()] = $attribute->targetClass;
                }

                $result->constructorArgs[$parameterReflection->getName()] = self::createArgDefinitionFromReflection(
                    $parameterReflection,
                    $constructorArrayParametersType,
                );
            }
        }

        foreach ($classReflection->getProperties() as $propertyReflection) {
            if ($propertyReflection->isStatic() || $propertyReflection->isPrivate() || $propertyReflection->isProtected()) {
                continue;
            }

            $propertyName = $propertyReflection->getName();
            if (isset($result->constructorArgs[$propertyName])) {
                //пропускаем т.к уже задано через конструктор
                continue;
            }

            $result->properties[$propertyReflection->getName()] = self::createArgDefinitionFromReflection($propertyReflection);
        }

        self::$definitionCache[$className] = $result;

        return $result;
    }

    protected static function createArgDefinitionFromReflection(
        ReflectionProperty|ReflectionParameter $reflection,
        ?array $constructorArrayParametersType = null,
    ): ArgDefinition {
        $tmp = new ArgDefinition();
        $tmp->title = $reflection->getName();
        $tmp->reflection = $reflection;

        foreach ($reflection->getAttributes(Map::class, ReflectionAttribute::IS_INSTANCEOF) as $mapAttributeReflection) {
            /** @var Map $mapAttribute */
            $mapAttribute = $mapAttributeReflection->newInstance();
            $tmp->maps[$mapAttribute->source ?? ''] = $mapAttribute->field;
        }

        if ($reflection instanceof ReflectionProperty ? $reflection->hasDefaultValue() : $reflection->isDefaultValueAvailable()) {
            $tmp->defaultValue = $reflection->getDefaultValue();
            $tmp->mustBeOverwritten = false;
        } elseif ($reflection instanceof ReflectionProperty ? $reflection->getType()->allowsNull() : $reflection->allowsNull()) {
            $tmp->defaultValue = null;
            $tmp->mustBeOverwritten = false;
        } else {
            $tmp->mustBeOverwritten = true;
        }

        if (!$reflection->hasType()) {
            $tmp->definitionType = DefinitionType::SIMPLE;
            $tmp->argType = 'mixed';
            return $tmp;
        }

        $type = $reflection->getType();
        if ($type instanceof ReflectionUnionType) {
            //@todo лютый говнокод, временное решение, нужно переделать
            //текущий код вообще не умеет в union type нормально, поэтому приходится изображать жесткую типизацию на основе первого
            $types = $type->getTypes();
            $tmp->argType = [];
            foreach ($types as $unionType) {
                $typeName = $unionType->getName();
                //@todo говнокод. определяем тип поля по последнему из union.
                //      будет ломаться если сделать объединение enum|object
                //      будет ломаться если будет любая типизация отличная от enum|enum|... или object|object|...
                if (enum_exists($typeName)) {
                    $tmp->definitionType = DefinitionType::ENUM;
                    $tmp->argType[] = $typeName;
                } else {
                    $tmp->definitionType = DefinitionType::OBJECT;
                    $tmp->argType[] = $typeName;
                }
            }
            return $tmp;
        }

        $typeName = $reflection->getType()->getName();
        switch ($typeName) {
            case 'int':
            case 'bool':
            case 'string':
            case 'float':
            case 'mixed':
                $tmp->definitionType = DefinitionType::SIMPLE;
                $tmp->argType = $typeName;
                break;
            case 'array':
                $tmp->definitionType = DefinitionType::ARRAY;

                if ($reflection instanceof ReflectionProperty) {
                    $attribute = $reflection->getAttributes(ArrayTypeOf::class, ReflectionAttribute::IS_INSTANCEOF);
                    if (count($attribute)) {
                        $arrayTypeOfAttribute = $attribute[0]->newInstance();
                        $tmp->argType = $arrayTypeOfAttribute->targetClass;
                    } else {
                        $tmp->argType = 'mixed';
                    }
                } else {
                    $tmp->argType = $constructorArrayParametersType[$tmp->title] ?? 'mixed';
                }
                break;
            default:
                if (enum_exists($typeName)) {
                    $tmp->definitionType = DefinitionType::ENUM;
                    $tmp->argType = $typeName;
                } else {
                    $tmp->definitionType = DefinitionType::OBJECT;
                    $tmp->argType = $typeName;
                }
                break;
        }
        return $tmp;
    }

    /**
     * @todo внедрить кеширование
     * @todo внедрить нормальную ошибку если не удается создать enum
     * @todo переиспользовать эту функцию чтобы не было дублирования кода
     * @todo как грязная идея - сделать фейковый definition из объекта с массивом с одним типом, заюзать основную функцию и потом вывести свойство
     */
    public static function createArrayFromData(string|array $targetClassArr, array $jsonData, ReflectionParameter|ReflectionProperty $reflection, bool $skipErrorsInArrayCreation, string $parentPath = '', ?string $source = null): array
    {
        $result = [];

        if (is_array($targetClassArr)) {
            $definitionTypes = [];
            foreach ($targetClassArr as $targetClass) {
                $definitionTypes[$targetClass] = self::getDefinitionTypeFromTargetClassname($targetClass);
            }
            $lastClass = end($targetClassArr);

            foreach ($jsonData as $index => $item) {
                foreach ($definitionTypes as $targetClass => $definitionType) {
                    try {
                        $tmp = self::_createArrItem($definitionType, $targetClass, $item, $reflection, $skipErrorsInArrayCreation, $parentPath . '[]', $source);
                    } catch (Throwable $e) {
                        if ($targetClass == $lastClass) {
                            if ($skipErrorsInArrayCreation) {
                                break;
                            }
                            throw $e;
                        }
                        continue;
                    }
                    $result[] = $tmp;
                    break;
                }
            }
        } else {
            //@todo тут стоит переписать как было (foreach element внутри switch) - сейчас мы делаем лишний switch для каждого элемента
            $definitionType = self::getDefinitionTypeFromTargetClassname($targetClassArr);
            foreach ($jsonData as $index => $item) {
                try {
                    $tmp = self::_createArrItem($definitionType, $targetClassArr, $item, $reflection, $skipErrorsInArrayCreation, $parentPath . '[]', $source);
                    $result[] = $tmp;
                } catch (RequiredArgumentException $e) {
                    if ($skipErrorsInArrayCreation) {
                        continue;
                    }
                    throw $e;
                }
            }
        }

        return $result;
    }

    /**
     * Определяет что собственно это такое.
     * @todo текущий код сломается на объединении типов
     */
    protected static function getDefinitionTypeFromTargetClassname(string $targetClass): DefinitionType
    {
        return match ($targetClass) {
            'int', 'bool', 'string', 'float', 'mixed' => DefinitionType::SIMPLE,
            default => enum_exists($targetClass) ? DefinitionType::ENUM : DefinitionType::OBJECT,
        };
    }

    /**
     * @todo элемент массива может быть массивом же
     */
    protected static function _createArrItem(
        DefinitionType $definitionType,
        string $targetClass,
        mixed $item,
        ReflectionParameter|ReflectionProperty $reflection,
        bool $skipErrorsInArrayCreation,
        string $parentPath = '',
        ?string $source = null
    ): mixed {
        switch ($definitionType) {
            case DefinitionType::OBJECT:
                return self::createClassFromData(
                    $targetClass,
                    is_object($item) ? $item : (object)$item,
                    $skipErrorsInArrayCreation,
                    $parentPath . '(' . ClassNameHelper::getShortClassName($targetClass) . ')',
                    $source
                );
            case DefinitionType::SIMPLE:
                return self::_formatSimple($targetClass, $item);
            case DefinitionType::ENUM:
                try {
                    return EnumHelper::formatEnumValue($targetClass, $item);
                } catch (Throwable $e) {
                    throw new RequiredArgumentException($reflection, $parentPath . '(' . ClassNameHelper::getShortClassName($targetClass) . ')');
                }
            default:
                //@todo придумать новую ошибку
                throw new RequiredArgumentException($reflection, $parentPath);
        }
    }

    /**
     * Приводит уже извлечённое значение (валидное json-данное) к типу параметра/свойства.
     * Используется на границе между DI-контейнером и гидратором: контейнер взял значение
     * из источника (POST/GET/...), знает на какой параметр оно идёт, и просит гидратор
     * сконструировать из него правильный тип.
     */
    public static function hydrateValue(ReflectionParameter|ReflectionProperty $reflection, mixed $valueFromInject, string $arrayTypeOf = 'mixed'): mixed
    {
        $targetType = $reflection->getType()?->getName() ?? 'mixed';

        if ($targetType === 'array') {
            return self::createArrayFromData($arrayTypeOf, $valueFromInject, $reflection, false);
        }

        if (enum_exists($targetType)) {
            try {
                return EnumHelper::formatEnumValue($targetType, $valueFromInject);
            } catch (ValueError $e) {
                throw new RequiredArgumentException($reflection);
            }
        }

        if (class_exists($targetType) && (is_object($valueFromInject) || is_array($valueFromInject))) {
            return self::createClassFromData($targetType, (object)$valueFromInject, false);
        }

        if (gettype($valueFromInject) !== 'NULL' && gettype($valueFromInject) != $targetType) {
            return TypeCaster::cast($valueFromInject, $targetType);
        }

        return $valueFromInject;
    }
}
