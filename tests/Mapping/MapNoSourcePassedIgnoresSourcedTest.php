<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\Tests\Mapping\_dto\DTOMapSourced;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapNoSourcePassedIgnoresSourcedTest extends TestCase
{
    public function testNoSourceIgnoresSourcedMapAndUsesPropertyName(): void
    {
        $result = DTOMapSourced::hydrateObject([
            'value' => 'A',
        ]);

        $this->assertSame('A', $result->value);
    }
}
