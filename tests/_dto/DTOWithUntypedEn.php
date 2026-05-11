<?php

namespace EntelisTeam\DTOHydrator\Tests\_dto;

use EntelisTeam\DTOHydrator\HydratorTrait;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\UntypedEnum;

class DTOWithUntypedEn
{
    use HydratorTrait;

    public UntypedEnum $enum;

}
