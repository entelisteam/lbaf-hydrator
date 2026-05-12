<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto;

use EntelisTeam\Lbaf\Hydrator\Attribute\Map;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class DTOMapMixed
{
    use HydratorTrait;

    #[Map('value_old', 'old')]
    #[Map('value_default')]
    public string $value;
}
