<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous\DTO;

use EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\DTOWithConstructor;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;

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