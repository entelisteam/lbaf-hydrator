<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\_dto;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;

class DTOWithConstructorAndProperties
{
    use HydratorTrait;

    public bool $isActive;
    public StringEnum $stringEnum;

    function __construct(
        public string  $title,
        public int     $age,
        public IntEnum $intEnum,

    )
    {

    }


}