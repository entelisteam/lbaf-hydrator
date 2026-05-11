<?php

namespace EntelisTeam\DTOHydrator\Tests\_dto;

use EntelisTeam\DTOHydrator\HydratorTrait;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\StringEnum;

class ReadonlyDTOWithConstructor
{
    use HydratorTrait;

    function __construct(
        public readonly string     $title,
        public readonly int        $age,
        public readonly bool       $isActive,
        public readonly IntEnum    $intEnum,
        public readonly StringEnum $stringEnum,
    )
    {

    }


}
