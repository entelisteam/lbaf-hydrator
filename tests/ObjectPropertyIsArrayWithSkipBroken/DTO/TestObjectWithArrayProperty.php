<?php

namespace EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayWithSkipBroken\DTO;

use EntelisTeam\DTOHydrator\Attribute\ArrayTypeOf;
use EntelisTeam\DTOHydrator\HydratorTrait;

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