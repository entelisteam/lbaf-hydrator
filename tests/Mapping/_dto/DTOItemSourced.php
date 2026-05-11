<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping\_dto;

use EntelisTeam\DTOHydrator\Attribute\Map;

class DTOItemSourced
{
    #[Map('name_old', 'old')]
    #[Map('name_default')]
    public string $name;
}
