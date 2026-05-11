<?php

namespace EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO;

use EntelisTeam\DTOHydrator\Attribute\ArrayTypeOf;
use EntelisTeam\DTOHydrator\HydratorTrait;
use EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\Objects\CarDTO;
use EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\Objects\DriverDTO;

class DTOArrayHeterogeneousWithConstructorTypedInline
{
    use HydratorTrait;

    /**
     * @param CarDTO[]|DriverDTO[] $objects
     */
    function __construct(#[ArrayTypeOf([CarDTO::class, DriverDTO::class])] public array $objects)
    {

    }

}