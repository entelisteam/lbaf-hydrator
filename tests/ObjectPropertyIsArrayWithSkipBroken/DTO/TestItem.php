<?php

namespace EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsArrayWithSkipBroken\DTO;

use EntelisTeam\DTOHydrator\Tests\_dto\Enums\StringEnum;

class TestItem
{
    public function __construct(
        public int $id,
        public string $name,
        public ?StringEnum $type,
    )
    {
    }
}