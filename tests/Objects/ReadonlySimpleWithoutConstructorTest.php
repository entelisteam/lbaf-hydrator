<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Objects;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\DTOHydrator\Tests\_dto\ReadonlyDTOWithoutConstructor;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\StringEnum;
use EntelisTeam\DTOHydrator\Tests\_traits\CheckObjectTrait;

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
