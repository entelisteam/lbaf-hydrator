<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto;

use EntelisTeam\Lbaf\Hydrator\Attribute\Map;

class DTOItemSourced
{
    #[Map('name_old', 'old')]
    #[Map('name_default')]
    public string $name;
}
