<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\_dto;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\IntEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;

class ReadonlyDTOWithoutConstructor
{
    use HydratorTrait;

    public readonly string $title;
    public readonly int $age;
    public readonly bool $isActive;

    public readonly IntEnum $intEnum;

    public readonly StringEnum $stringEnum;

}
