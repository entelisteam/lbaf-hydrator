<?php

declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Rector\M20260511_1500_DTOFactoryToHydrator\Source;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class SomeDTO
{
    use HydratorTrait;

    public function __construct(public readonly int $x = 0)
    {
    }
}
