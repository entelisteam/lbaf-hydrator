<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping\_dto;

use EntelisTeam\DTOHydrator\Attribute\Map;
use EntelisTeam\DTOHydrator\HydratorTrait;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\StringEnum;

class DTOMapEnum
{
    use HydratorTrait;

    #[Map('color_key')]
    public StringEnum $color;
}
