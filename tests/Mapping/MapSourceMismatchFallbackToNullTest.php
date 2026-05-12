<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto\DTOMapMixed;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapSourceMismatchFallbackToNullTest extends TestCase
{
    public function testUnknownSourceFallsBackToNullMap(): void
    {
        $result = DTOMapMixed::hydrateObject([
            'value_default' => 'Y',
        ], false, 'unknown');

        $this->assertSame('Y', $result->value);
    }
}
