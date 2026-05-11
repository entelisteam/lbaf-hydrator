<?php

namespace EntelisTeam\DTOHydrator\Tests\_dto;

use EntelisTeam\DTOHydrator\HydratorTrait;

class DTOWithConstructorAndLogic
{
    use HydratorTrait;

    public string $title;

    function __construct(string $title)
    {
        $this->title = 'Mr. ' . $title;
    }

}