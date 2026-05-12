<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Objects;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\ReadonlyDTOWithoutConstructor;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_traits\CheckObjectTrait;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class ReadonlySimpleWithoutConstructorTest extends TestCase
{
    use CheckObjectTrait;

    public function testReadonlySimpleWithoutConstructor(): void
    {
        $data = (object)[
            'title' => 'John',
            'age' => 30,
            'isActive' => true,
            'intEnum' => IntEnum::BLUE_COLOR->value,
            'stringEnum' => StringEnum::BLUE_COLOR->value,
        ];

        $instance = ReadonlyDTOWithoutConstructor::hydrateObject($data);

        $this->checkObject($instance);
    }

    public function testReadonlySimpleEmptyValuesWithoutConstructor(): void
    {
        $data = (object)[
            'title' => '',
            'age' => 0,
            'isActive' => true,
            'intEnum' => IntEnum::BLUE_COLOR->value,
            'stringEnum' => StringEnum::BLUE_COLOR->value,
        ];

        $instance = ReadonlyDTOWithoutConstructor::hydrateObject($data);

        $this->checkObject($instance);
    }

}
