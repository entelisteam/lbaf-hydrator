<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping\_dto;

use EntelisTeam\DTOHydrator\Attribute\Map;
use EntelisTeam\DTOHydrator\HydratorTrait;

class DTOMapCtor
{
    use HydratorTrait;

    public string $userName;

    public function __construct(
        #[Map('user_name')] string $userName,
    ) {
        $this->userName = $userName;
    }
}
