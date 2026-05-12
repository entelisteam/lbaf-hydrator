<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\Objects;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class DriverDTO
{
    use HydratorTrait;

    public string $name;

    public int $age;


}