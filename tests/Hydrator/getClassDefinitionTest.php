<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Hydrator;

use EntelisTeam\Lbaf\Reflection\MethodParameters;
use EntelisTeam\Lbaf\Hydrator\Definition\ArgDefinition;
use EntelisTeam\Lbaf\Hydrator\Definition\ClassDefinition;
use EntelisTeam\Lbaf\Hydrator\Definition\DefinitionType;
use EntelisTeam\Lbaf\Hydrator\Internal\HydratorEngine;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use EntelisTeam\Lbaf\Hydrator\Tests\Hydrator\_testObjects\ArrayClass;
use EntelisTeam\Lbaf\Hydrator\Tests\Hydrator\_testObjects\SimpleClass;

#[
    CoversClass(HydratorEngine::class),
]
final class getClassDefinitionTest extends TestCase
{
    public static function provider(): array
    {
        //провайдер отдаёт только строковые имена: PHPUnit 12.5+ пытается сериализовать
        //значения data provider'а для кеша, а ReflectionParameter/ReflectionProperty
        //сериализовать нельзя. Ожидаемая структура задаётся именем builder-метода.
        return [
            'SimpleClass' => [SimpleClass::class, 'buildSimpleClassDefinition'],
            'ArrayClass' => [ArrayClass::class, 'buildArrayClassDefinition'],
        ];
    }

    #[DataProvider('provider')]
    public function testGeneration(string $className, string $expectedBuilder): void
    {
        $expected = $this->$expectedBuilder();

        $reflectionClass = new ReflectionClass(HydratorEngine::class);
        $method = $reflectionClass->getMethod('getClassDefinition');
        $method->setAccessible(true);
        $actual = $method->invoke(null, $className);

        $this->assertClassDefinitionEquals($expected, $actual, $className);
    }

    /**
     * Сравнивает ClassDefinition поэлементно, минуя ReflectionParameter/Property —
     * PHPUnit assertEqualsCanonicalizing сериализует объекты для canonicalization,
     * что запрещено для Reflection-объектов.
     */
    private function assertClassDefinitionEquals(ClassDefinition $expected, ClassDefinition $actual, string $context): void
    {
        $this->assertSame($expected->reflection->getName(), $actual->reflection->getName(), $context . ': class reflection name');

        $this->assertSame(
            array_keys($expected->constructorArgs ?? []),
            array_keys($actual->constructorArgs ?? []),
            $context . ': constructor arg keys',
        );
        foreach ($expected->constructorArgs ?? [] as $key => $expectedArg) {
            $this->assertArgDefinitionEquals($expectedArg, $actual->constructorArgs[$key], $context . '.constructor.' . $key);
        }

        $this->assertSame(
            array_keys($expected->properties),
            array_keys($actual->properties),
            $context . ': property keys',
        );
        foreach ($expected->properties as $key => $expectedProperty) {
            $this->assertArgDefinitionEquals($expectedProperty, $actual->properties[$key], $context . '.property.' . $key);
        }
    }

    private function assertArgDefinitionEquals(ArgDefinition $expected, ArgDefinition $actual, string $context): void
    {
        $this->assertSame($expected->title, $actual->title, $context . ': title');
        $this->assertSame($expected->definitionType, $actual->definitionType, $context . ': definitionType');
        $this->assertSame($expected->argType, $actual->argType, $context . ': argType');
        $this->assertSame($expected->mustBeOverwritten, $actual->mustBeOverwritten, $context . ': mustBeOverwritten');
        $this->assertSame(get_class($expected->reflection), get_class($actual->reflection), $context . ': reflection type');
        $this->assertSame($expected->reflection->getName(), $actual->reflection->getName(), $context . ': reflection name');
    }

    private function buildSimpleClassDefinition(): ClassDefinition
    {
        $simpleClassDefinition = new ClassDefinition();
        $simpleClassDefinition->reflection = new ReflectionClass(SimpleClass::class);
        $simpleClassDefinition->constructorArgs = [
            'intConstructor' => (new ArgDefinition())
                ->setTitle('intConstructor')
                ->setDefinitionType(DefinitionType::SIMPLE)
                ->setArgType('int')
                ->setMustBeOverwritten(true)
                ->setReflection(
                    MethodParameters::getReflection(
                        $simpleClassDefinition->reflection->getConstructor(),
                        'intConstructor',
                    )
                ),
        ];
        $simpleClassDefinition->properties = [
            'boolProperty' => (new ArgDefinition())
                ->setTitle('boolProperty')
                ->setDefinitionType(DefinitionType::SIMPLE)
                ->setArgType('bool')
                ->setMustBeOverwritten(true)
                ->setReflection($simpleClassDefinition->reflection->getProperty('boolProperty')),
        ];
        return $simpleClassDefinition;
    }

    private function buildArrayClassDefinition(): ClassDefinition
    {
        $arrayClassDefinition = new ClassDefinition();
        $arrayClassDefinition->reflection = new ReflectionClass(ArrayClass::class);
        $arrayClassDefinition->constructorArgs = [
            'arrayConstructor' => (new ArgDefinition())
                ->setTitle('arrayConstructor')
                ->setDefinitionType(DefinitionType::ARRAY)
                ->setArgType('int')
                ->setMustBeOverwritten(true)
                ->setReflection(
                    MethodParameters::getReflection(
                        $arrayClassDefinition->reflection->getConstructor(),
                        'arrayConstructor',
                    )
                ),
        ];
        $arrayClassDefinition->properties = [
            'classArray' => (new ArgDefinition())
                ->setTitle('classArray')
                ->setDefinitionType(DefinitionType::ARRAY)
                ->setArgType(SimpleClass::class)
                ->setMustBeOverwritten(true)
                ->setReflection($arrayClassDefinition->reflection->getProperty('classArray')),
        ];
        return $arrayClassDefinition;
    }
}
