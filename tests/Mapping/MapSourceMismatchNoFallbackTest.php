<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto\DTOMapSourced;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapSourceMismatchNoFallbackTest extends TestCase
{
    public function testUnknownSourceWithoutFallbackUsesPropertyName(): void
    {
        $result = DTOMapSourced::hydrateObject([
            'value' => 'Z',
        ], false, 'unknown');

        $this->assertSame('Z', $result->value);
    }
}
