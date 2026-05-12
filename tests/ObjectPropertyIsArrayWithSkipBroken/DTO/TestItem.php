<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayWithSkipBroken\DTO;

use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;

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