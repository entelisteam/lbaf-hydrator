<?php

namespace EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\Objects;

use EntelisTeam\DTOHydrator\HydratorTrait;

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