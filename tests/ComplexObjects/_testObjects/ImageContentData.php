<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

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