<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping\_dto;

use EntelisTeam\DTOHydrator\Attribute\Map;
use EntelisTeam\DTOHydrator\HydratorTrait;

class DTOMapPromoted
{
    use HydratorTrait;

    public function __construct(
        #[Map('full_name')] public string $fullName,
    ) {
    }
}
