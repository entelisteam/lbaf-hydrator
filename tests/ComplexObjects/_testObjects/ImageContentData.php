<?php

namespace EntelisTeam\DTOHydrator\Tests\ComplexObjects\_testObjects;

use EntelisTeam\DTOHydrator\HydratorTrait;

class ImageContentData
{
    use HydratorTrait;

    function __construct(
        public string $url,
        public int    $size,
    )
    {

    }
}