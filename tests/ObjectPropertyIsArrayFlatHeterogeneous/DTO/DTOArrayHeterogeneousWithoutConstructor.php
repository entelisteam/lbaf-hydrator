<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO;

use EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\Objects\CarDTO;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\Objects\DriverDTO;

class DTOArrayHeterogeneousWithoutConstructor
{
    use HydratorTrait;


    #[ArrayTypeOf([CarDTO::class, DriverDTO::class])]
    public array $objects;

}