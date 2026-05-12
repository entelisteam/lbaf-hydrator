<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto\DTOMapSourced;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapHydrateArrayPropagatesSourceTest extends TestCase
{
    public function testHydrateArrayPropagatesSourceToEachItem(): void
    {
        $result = DTOMapSourced::hydrateArray([
            ['value_old' => 'A'],
            ['value_old' => 'B'],
        ], false, 'old');

        $this->assertCount(2, $result);
        $this->assertSame('A', $result[0]->value);
        $this->assertSame('B', $result[1]->value);
    }
}
