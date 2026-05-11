<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator;

use EntelisTeam\DTOHydrator\Exception\RequiredArgumentException;
use EntelisTeam\DTOHydrator\Internal\HydratorEngine;
use EntelisTeam\Reflection\ClassNameHelper;
use ReflectionParameter;
use ReflectionProperty;

class Hydrator
{
    public function __construct(protected string $className)
    {
    }

    /**
     * Создает экземпляр объекта на основе данных в структуре $jsonData.
     * @throws RequiredArgumentException
     */
    public function hydrateObject(object|array $jsonData, bool $skipErrorsInArrayCreation = false, ?string $source = null, string $path = ''): ?object
    {
        if (is_array($jsonData)) {
            $jsonData = (object)$jsonData;
        }
        return HydratorEngine::createClassFromData(
            $this->className,
            $jsonData,
            $skipErrorsInArrayCreation,
            $path,
            $source
        );
    }

    /**
     * Создает массив объектов на основе данных в структуре $jsonData.
     */
    public function hydrateArray(array $jsonDataArray, bool $skipErrorsInArrayCreation = false, ?string $source = null): array
    {
        $result = [];
        foreach ($jsonDataArray as $index => $item) {
            try {
                $result[] = $this->hydrateObject($item, $skipErrorsInArrayCreation, $source, '[](' . ClassNameHelper::getShortClassName($this->className) . ')');
            } catch (RequiredArgumentException $e) {
                if ($skipErrorsInArrayCreation) {
                    continue;
                }
                throw $e;
            }
        }
        return $result;
    }

    /**
     * Приводит уже извлечённое значение к типу параметра/свойства.
     * Используется на границе между DI-контейнером и гидратором.
     */
    public static function hydrateValue(ReflectionParameter|ReflectionProperty $reflection, mixed $valueFromInject, string $arrayTypeOf = 'mixed'): mixed
    {
        return HydratorEngine::hydrateValue($reflection, $valueFromInject, $arrayTypeOf);
    }
}
