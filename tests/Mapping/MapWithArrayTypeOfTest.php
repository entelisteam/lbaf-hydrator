<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto\DTOItem;
use EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto\DTOMapArrayOf;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapWithArrayTypeOfTest extends TestCase
{
    public function testMapCombinedWithArrayTypeOf(): void
    {
        $result = DTOMapArrayOf::hydrateObject([
            'items_list' => [
                ['name' => 'a'],
                ['name' => 'b'],
            ],
        ]);

        $this->assertCount(2, $result->items);
        $this->assertInstanceOf(DTOItem::class, $result->items[0]);
        $this->assertSame('a', $result->items[0]->name);
        $this->assertSame('b', $result->items[1]->name);
    }
}
