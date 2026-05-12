<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\_dto;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;

class DTOWithConstructor
{
    use HydratorTrait;

    function __construct(
        public string     $title,
        public int        $age,
        public bool       $isActive,
        public IntEnum    $intEnum,
        public StringEnum $stringEnum,
    )
    {

    }


}