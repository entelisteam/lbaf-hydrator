<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class TextContentData
{
    use HydratorTrait;

    function __construct(public string $text)
    {
    }
}