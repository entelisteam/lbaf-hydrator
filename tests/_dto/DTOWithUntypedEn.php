<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\_dto;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\UntypedEnum;

class DTOWithUntypedEn
{
    use HydratorTrait;

    public UntypedEnum $enum;

}
