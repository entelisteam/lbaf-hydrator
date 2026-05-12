<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto;

use EntelisTeam\Lbaf\Hydrator\Attribute\Map;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;

class DTOMapEnum
{
    use HydratorTrait;

    #[Map('color_key')]
    public StringEnum $color;
}
