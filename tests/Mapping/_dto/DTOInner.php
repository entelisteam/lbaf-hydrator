<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto;

use EntelisTeam\Lbaf\Hydrator\Attribute\Map;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class DTOInner
{
    use HydratorTrait;

    #[Map('inner_old', 'old')]
    #[Map('inner_default')]
    public string $innerValue;
}
