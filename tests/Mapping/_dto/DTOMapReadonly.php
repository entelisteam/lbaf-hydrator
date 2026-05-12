<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto;

use EntelisTeam\Lbaf\Hydrator\Attribute\Map;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class DTOMapReadonly
{
    use HydratorTrait;

    #[Map('user_id')]
    public readonly int $userId;
}
