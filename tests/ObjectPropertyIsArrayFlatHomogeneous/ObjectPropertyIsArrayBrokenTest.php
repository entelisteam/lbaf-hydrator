<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Broken\DTOUntypedArrayParameter;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Broken\DTOUntypedArrayProperty;
use EntelisTeam\Lbaf\Hydrator\Tests\_traits\CheckObjectTrait;


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
