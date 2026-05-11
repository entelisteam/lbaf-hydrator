<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping\_dto;

use EntelisTeam\DTOHydrator\Attribute\Map;
use EntelisTeam\DTOHydrator\HydratorTrait;

class DTOMapMixed
{
    use HydratorTrait;

    #[Map('value_old', 'old')]
    #[Map('value_default')]
    public string $value;
}
