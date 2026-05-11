<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\Tests\Mapping\_dto\DTOMapSourced;
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
