<?php

namespace EntelisTeam\DTOHydrator\Tests\ComplexObjects\_testObjects;

use EntelisTeam\DTOHydrator\HydratorTrait;

class TitleContentData
{
    use HydratorTrait;

    function __construct(public string $text)
    {
    }
}