<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous;

use EntelisTeam\DTOHydrator\Exception\RequiredArgumentException;
use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use EntelisTeam\DTOHydrator\Tests\_dto\DTOWithConstructor;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\StringEnum;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\UntypedEnum;
use EntelisTeam\DTOHydrator\Tests\_traits\CheckObjectTrait;
use EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous\DTO\DTOArrayHomogeneousUntypedEnumsWithoutConstructor;
use EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous\DTO\DTOArrayHomogeneousWithoutConstructor;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class ObjectPropertyIsArrayFlatWithoutConstructorTest extends TestCase
{

    use CheckObjectTrait;

    public static function badProvider(): array
    {
        return [
            [(object)['untypedEnums' => ['OLOLO']]],
            [(object)['ololo' => ['GREEN']]],
            [(object)[]],
        ];
    }

    public function testArray(): void
    {
        $instance = new DTOArrayHomogeneousWithoutConstructor();
        $instance->stringEnums = [StringEnum::RED_COLOR, StringEnum::GREEN_COLOR];
        $instance->strings = ['blue', 'green'];
        $instance->intEnums = [IntEnum::GREEN_COLOR, IntEnum::BLUE_COLOR];
        $instance->objects = [
            new DTOWithConstructor(
                title: 'John',
                age: 30,
                isActive: true,
                intEnum: IntEnum::BLUE_COLOR,
                stringEnum: StringEnum::BLUE_COLOR,
            ),
            new DTOWithConstructor(
                title: 'Mike',
                age: 10,
                isActive: false,
                intEnum: IntEnum::GREEN_COLOR,
                stringEnum: StringEnum::GREEN_COLOR,
            )
        ];

        $this->checkObject($instance);
    }

    public function testArrayUntypedEnum(): void
    {
        $instance = new DTOArrayHomogeneousUntypedEnumsWithoutConstructor();
        $instance->untypedEnums = [UntypedEnum::GREEN];

        $jsonData = (object)['untypedEnums' => ['GREEN']];

        $newInstance = $instance::getHydrator()->hydrateObject($jsonData);

        $this->assertEqualsCanonicalizing($instance, $newInstance);
    }

    #[DataProvider('badProvider')]
    public function testException(object $jsonData): void
    {
        $this->expectException(RequiredArgumentException::class);
        DTOArrayHomogeneousUntypedEnumsWithoutConstructor::getHydrator()->hydrateObject($jsonData);
    }


}
