<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\DTODefaultValuesWithoutConstructor;
use EntelisTeam\Lbaf\Hydrator\Tests\_traits\CheckObjectTrait;

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
