<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Hydrator\_testObjects;

use EntelisTeam\DTOHydrator\Attribute\ArrayTypeOf;

class ArrayClass
{

    //простые типы
    #[ArrayTypeOf(SimpleClass::class)]
    public array $classArray;

    //массивы
    #[
        ArrayTypeOf('arrayConstructor', 'int'),
    ]
    function __construct(

        public array $arrayConstructor,
    )
    {
    }

}