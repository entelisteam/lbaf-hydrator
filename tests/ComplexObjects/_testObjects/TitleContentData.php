<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class TitleContentData
{
    use HydratorTrait;

    function __construct(public string $text)
    {
    }
}