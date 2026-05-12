<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto;

use EntelisTeam\Lbaf\Hydrator\Attribute\Map;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class DTOOuter
{
    use HydratorTrait;

    #[Map('child_old', 'old')]
    #[Map('child_default')]
    public DTOInner $child;
}
