<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\Tests\Mapping\_dto\DTOMapSourced;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapSourceMatchTest extends TestCase
{
    public function testSourceMatchUsesMappedKey(): void
    {
        $result = DTOMapSourced::hydrateObject([
            'value_old' => 'X',
        ], false, 'old');

        $this->assertSame('X', $result->value);
    }
}
