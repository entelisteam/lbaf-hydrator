<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\DTOHydrator\Tests\_dto\DTODefaultValuesWithoutConstructor;
use EntelisTeam\DTOHydrator\Tests\_traits\CheckObjectTrait;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class FactoryDefaultValuesTest extends TestCase
{

    use CheckObjectTrait;

    public function testDefaultValues(): void
    {
        $instance = new DTODefaultValuesWithoutConstructor();
        $this->checkObject($instance);
    }

}
