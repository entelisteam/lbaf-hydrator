<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\Tests\Mapping\_dto\DTOMapDefault;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapMissingKeyUsesDefaultTest extends TestCase
{
    public function testMissingMappedKeyFallsBackToDefault(): void
    {
        $result = DTOMapDefault::hydrateObject([]);

        $this->assertSame(42, $result->userId);
    }
}
