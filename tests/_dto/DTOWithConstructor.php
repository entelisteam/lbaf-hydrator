<?php

namespace EntelisTeam\DTOHydrator\Tests\_dto;

use EntelisTeam\DTOHydrator\HydratorTrait;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\StringEnum;

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