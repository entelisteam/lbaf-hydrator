<?php

namespace EntelisTeam\DTOHydrator\Tests\_dto;

use EntelisTeam\DTOHydrator\HydratorTrait;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\StringEnum;

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