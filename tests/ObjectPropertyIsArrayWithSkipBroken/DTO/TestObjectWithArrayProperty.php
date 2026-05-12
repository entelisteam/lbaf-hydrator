<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayWithSkipBroken\DTO;

use EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class TestObjectWithArrayProperty
{
    use HydratorTrait;

    /**
     * @var TestItem[]
     */
    #[
        ArrayTypeOf(TestItem::class),
    ]
    public array $items = [];

}