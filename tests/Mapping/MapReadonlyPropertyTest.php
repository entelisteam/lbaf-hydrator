<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto\DTOMapReadonly;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapReadonlyPropertyTest extends TestCase
{
    public function testMapOnReadonlyProperty(): void
    {
        $result = DTOMapReadonly::hydrateObject([
            'user_id' => 7,
        ]);

        $this->assertSame(7, $result->userId);
    }
}
