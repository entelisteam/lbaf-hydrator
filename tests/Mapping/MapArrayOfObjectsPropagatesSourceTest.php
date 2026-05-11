<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\Tests\Mapping\_dto\DTOMapArraySourced;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapArrayOfObjectsPropagatesSourceTest extends TestCase
{
    public function testSourcePropagatesToArrayElements(): void
    {
        $result = DTOMapArraySourced::hydrateObject([
            'items_list' => [
                ['name_old' => 'A'],
                ['name_old' => 'B'],
            ],
        ], false, 'old');

        $this->assertCount(2, $result->items);
        $this->assertSame('A', $result->items[0]->name);
        $this->assertSame('B', $result->items[1]->name);
    }

    public function testNoSourcePropagatesToArrayElements(): void
    {
        $result = DTOMapArraySourced::hydrateObject([
            'items_default' => [
                ['name_default' => 'A'],
                ['name_default' => 'B'],
            ],
        ]);

        $this->assertCount(2, $result->items);
        $this->assertSame('A', $result->items[0]->name);
        $this->assertSame('B', $result->items[1]->name);
    }
}
