<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\_dto;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;

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