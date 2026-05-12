<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO;

use EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\Objects\CarDTO;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\Objects\DriverDTO;

class DTOArrayHeterogeneousWithConstructor
{
    use HydratorTrait;

    /**
     * @param CarDTO[]|DriverDTO[] $objects
     */
    #[ArrayTypeOf('objects', [CarDTO::class, DriverDTO::class])]
    function __construct(public array $objects)
    {

    }

}