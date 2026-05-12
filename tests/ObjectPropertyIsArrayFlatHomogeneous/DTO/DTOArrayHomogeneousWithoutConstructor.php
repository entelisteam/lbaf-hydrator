<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous\DTO;

use EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\DTOWithConstructor;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;

class DTOArrayHomogeneousWithoutConstructor
{
    use HydratorTrait;

    #[ArrayTypeOf(StringEnum::class)]
    public array $stringEnums;

    #[ArrayTypeOf(IntEnum::class)]
    public array $intEnums;

    #[ArrayTypeOf('string')]
    public array $strings;

    #[ArrayTypeOf(DTOWithConstructor::class)]
    public array $objects;

}