<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Hydrator\_testObjects;

class SimpleClass
{
    public bool $boolProperty;

    function __construct(
        public int $intConstructor,
    )
    {
    }

}