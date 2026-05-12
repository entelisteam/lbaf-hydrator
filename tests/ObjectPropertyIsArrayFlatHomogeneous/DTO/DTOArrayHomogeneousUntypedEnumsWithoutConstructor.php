<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous\DTO;

use EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\UntypedEnum;

class DTOArrayHomogeneousUntypedEnumsWithoutConstructor
{
    use HydratorTrait;

    #[ArrayTypeOf(UntypedEnum::class)]
    public array $untypedEnums;


}