<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto;

use EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf;
use EntelisTeam\Lbaf\Hydrator\Attribute\Map;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class DTOMapArraySourced
{
    use HydratorTrait;

    #[Map('items_list', 'old')]
    #[Map('items_default')]
    #[ArrayTypeOf(DTOItemSourced::class)]
    public array $items;
}
