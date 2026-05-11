<?php

namespace EntelisTeam\DTOHydrator\Tests\_dto;

use EntelisTeam\DTOHydrator\HydratorTrait;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\StringEnum;

class DTOWithObjectInConstructor
{
    use HydratorTrait;

    function __construct(
        public string             $title,
        public StringEnum         $stringEnum,
        public DTOWithConstructor $object,
    )
    {

    }


}