<?php

namespace EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayFlatHomogeneous\DTO;

use EntelisTeam\DTOHydrator\Attribute\ArrayTypeOf;
use EntelisTeam\DTOHydrator\HydratorTrait;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\UntypedEnum;

class DTOArrayHomogeneousUntypedEnumsWithoutConstructor
{
    use HydratorTrait;

    #[ArrayTypeOf(UntypedEnum::class)]
    public array $untypedEnums;


}