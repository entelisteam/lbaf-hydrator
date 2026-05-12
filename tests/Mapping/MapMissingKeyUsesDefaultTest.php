<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto\DTOMapDefault;
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
