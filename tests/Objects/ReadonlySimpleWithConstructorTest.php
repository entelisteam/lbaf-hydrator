<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Objects;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\ReadonlyDTOWithConstructor;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_traits\CheckObjectTrait;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class ReadonlySimpleWithConstructorTest extends TestCase
{
    use CheckObjectTrait;

    public function testReadonlySimpleWithConstructor(): void
    {

        $instance = new ReadonlyDTOWithConstructor(
            title: 'John',
            age: 30,
            isActive: true,
            intEnum: IntEnum::BLUE_COLOR,
            stringEnum: StringEnum::BLUE_COLOR,
        );

        $this->checkObject($instance);
    }

    public function testReadonlySimpleEmptyValuesWithConstructor(): void
    {

        $instance = new ReadonlyDTOWithConstructor(
            title: '',
            age: 0,
            isActive: true,
            intEnum: IntEnum::BLUE_COLOR,
            stringEnum: StringEnum::BLUE_COLOR,
        );

        $this->checkObject($instance);
    }

}
