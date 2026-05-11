<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping\_dto;

use EntelisTeam\DTOHydrator\Attribute\Map;
use EntelisTeam\DTOHydrator\HydratorTrait;

class DTOMapProperty
{
    use HydratorTrait;

    #[Map('user_id')]
    public int $userId;

    public string $title;
}
