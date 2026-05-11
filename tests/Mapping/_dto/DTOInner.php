<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping\_dto;

use EntelisTeam\DTOHydrator\Attribute\Map;
use EntelisTeam\DTOHydrator\HydratorTrait;

class DTOInner
{
    use HydratorTrait;

    #[Map('inner_old', 'old')]
    #[Map('inner_default')]
    public string $innerValue;
}
