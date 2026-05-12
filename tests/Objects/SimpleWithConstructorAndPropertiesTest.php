<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Objects;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\DTOWithConstructorAndProperties;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_traits\CheckObjectTrait;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class SimpleWithConstructorAndPropertiesTest extends TestCase
{

    use CheckObjectTrait;

    public function testSimpleWithConstructorAndProperties(): void
    {
        $instance = new DTOWithConstructorAndProperties(
            title: 'John',
            age: 30,
            intEnum: IntEnum::BLUE_COLOR,
        );
        $instance->isActive = true;
        $instance->stringEnum = StringEnum::BLUE_COLOR;

        $this->checkObject($instance);
    }


}
