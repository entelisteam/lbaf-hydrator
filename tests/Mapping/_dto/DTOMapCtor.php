<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto;

use EntelisTeam\Lbaf\Hydrator\Attribute\Map;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

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
