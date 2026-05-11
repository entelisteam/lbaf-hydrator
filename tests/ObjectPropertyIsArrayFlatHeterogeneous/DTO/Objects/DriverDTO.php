<?php

namespace EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\Objects;

use EntelisTeam\DTOHydrator\HydratorTrait;

class DriverDTO
{
    use HydratorTrait;

    public string $name;

    public int $age;


}