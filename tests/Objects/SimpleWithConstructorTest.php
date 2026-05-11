<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Objects;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\DTOHydrator\Tests\_dto\DTOWithConstructor;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\StringEnum;
use EntelisTeam\DTOHydrator\Tests\_traits\CheckObjectTrait;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class SimpleWithConstructorTest extends TestCase
{

    use CheckObjectTrait;

    public function testSimpleWithConstructor(): void
    {
        $instance = new DTOWithConstructor(
            title: 'John',
            age: 30,
            isActive: true,
            intEnum: IntEnum::BLUE_COLOR,
            stringEnum: StringEnum::BLUE_COLOR,
        );

        $this->checkObject($instance);
    }

}
