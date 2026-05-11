<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Hydrator\_testObjects;

class SimpleClass
{
    public bool $boolProperty;

    function __construct(
        public int $intConstructor,
    )
    {
    }

}