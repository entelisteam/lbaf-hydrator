<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto\DTOMapSourced;
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
