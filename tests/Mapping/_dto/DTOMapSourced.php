<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto;

use EntelisTeam\Lbaf\Hydrator\Attribute\Map;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class DTOMapSourced
{
    use HydratorTrait;

    #[Map('value_old', 'old')]
    public string $value;
}
