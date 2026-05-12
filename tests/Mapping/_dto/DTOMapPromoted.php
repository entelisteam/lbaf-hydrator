<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto;

use EntelisTeam\Lbaf\Hydrator\Attribute\Map;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class DTOMapPromoted
{
    use HydratorTrait;

    public function __construct(
        #[Map('full_name')] public string $fullName,
    ) {
    }
}
