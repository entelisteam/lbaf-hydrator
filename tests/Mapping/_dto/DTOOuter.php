<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping\_dto;

use EntelisTeam\DTOHydrator\Attribute\Map;
use EntelisTeam\DTOHydrator\HydratorTrait;

class DTOOuter
{
    use HydratorTrait;

    #[Map('child_old', 'old')]
    #[Map('child_default')]
    public DTOInner $child;
}
