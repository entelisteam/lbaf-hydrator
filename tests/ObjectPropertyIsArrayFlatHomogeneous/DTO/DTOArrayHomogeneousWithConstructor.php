<?php

namespace EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous\DTO;

use EntelisTeam\DTOHydrator\Attribute\ArrayTypeOf;
use EntelisTeam\DTOHydrator\HydratorTrait;
use EntelisTeam\DTOHydrator\Tests\_dto\DTOWithConstructor;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\StringEnum;

class DTOArrayHomogeneousWithConstructor
{
    use HydratorTrait;


    #[
        ArrayTypeOf('stringEnums', StringEnum::class),
        ArrayTypeOf('intEnums', IntEnum::class),
        ArrayTypeOf('strings', 'string'),
        ArrayTypeOf('objects', DTOWithConstructor::class),
    ]
    public function __construct(
        public array $stringEnums,
        public array $intEnums,
        public array $strings,
        public array $objects,
    )
    {

    }

}