<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Objects;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\DTOWithoutConstructor;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_traits\CheckObjectTrait;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class SimpleWithoutConstructorTest extends TestCase
{
    use CheckObjectTrait;

    public function testSimpleWithoutConstructor(): void
    {

        $instance = new DTOWithoutConstructor();
        $instance->title = 'John';
        $instance->age = 30;
        $instance->isActive = true;

        $instance->intEnum = IntEnum::BLUE_COLOR;
        $instance->stringEnum = StringEnum::BLUE_COLOR;

        $this->checkObject($instance);
    }

    public function testSimpleEmptyValuesWithoutConstructor(): void
    {

        $instance = new DTOWithoutConstructor();
        $instance->title = '';
        $instance->age = 0;
        $instance->isActive = true;

        $instance->intEnum = IntEnum::BLUE_COLOR;
        $instance->stringEnum = StringEnum::BLUE_COLOR;

        $this->checkObject($instance);
    }

}
