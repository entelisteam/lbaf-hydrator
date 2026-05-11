<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping\_dto;

use EntelisTeam\DTOHydrator\Attribute\ArrayTypeOf;
use EntelisTeam\DTOHydrator\Attribute\Map;
use EntelisTeam\DTOHydrator\HydratorTrait;

class DTOMapArrayOf
{
    use HydratorTrait;

    #[Map('items_list')]
    #[ArrayTypeOf(DTOItem::class)]
    public array $items;
}
