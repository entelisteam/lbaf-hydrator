<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\_dto;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class DTOWithConstructorAndLogic
{
    use HydratorTrait;

    public string $title;

    function __construct(string $title)
    {
        $this->title = 'Mr. ' . $title;
    }

}