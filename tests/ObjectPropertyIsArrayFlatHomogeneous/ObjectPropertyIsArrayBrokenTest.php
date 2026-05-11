<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\DTOHydrator\Tests\_dto\Broken\DTOUntypedArrayParameter;
use EntelisTeam\DTOHydrator\Tests\_dto\Broken\DTOUntypedArrayProperty;
use EntelisTeam\DTOHydrator\Tests\_traits\CheckObjectTrait;


#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class ObjectPropertyIsArrayBrokenTest extends TestCase
{

    use CheckObjectTrait;

    public function testUnspecifiedProperty(): void
    {
        $instance = new DTOUntypedArrayProperty();
        $instance->arr = ['foo', 'bar',];

        $this->checkObject($instance);
    }

    public function testUnspecifiedParameter(): void
    {
        $instance = new DTOUntypedArrayParameter(['foo', 'bar',]);
        $this->checkObject($instance);
    }

}
