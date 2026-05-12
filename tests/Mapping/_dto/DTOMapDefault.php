<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto;

use EntelisTeam\Lbaf\Hydrator\Attribute\Map;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class DTOMapDefault
{
    use HydratorTrait;

    #[Map('user_id')]
    public int $userId = 42;
}
