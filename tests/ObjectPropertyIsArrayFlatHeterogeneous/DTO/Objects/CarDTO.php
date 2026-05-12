<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\Objects;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class CarDTO
{
    use HydratorTrait;

    function __construct(
        public string    $model,
        public int       $year,
        public DriverDTO $driver,
    )
    {

    }


}