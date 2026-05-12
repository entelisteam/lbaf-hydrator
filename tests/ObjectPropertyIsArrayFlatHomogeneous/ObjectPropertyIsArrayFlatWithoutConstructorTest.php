<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous;

use EntelisTeam\Lbaf\Hydrator\Exception\RequiredArgumentException;
use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\DTOWithConstructor;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\UntypedEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_traits\CheckObjectTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous\DTO\DTOArrayHomogeneousUntypedEnumsWithoutConstructor;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous\DTO\DTOArrayHomogeneousWithoutConstructor;

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
