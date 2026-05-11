<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\Tests\Mapping\_dto\DTOMapProperty;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapNoSourcePassedUsesNullMapTest extends TestCase
{
    public function testNoSourceAppliesNullMap(): void
    {
        $result = DTOMapProperty::hydrateObject([
            'user_id' => 5,
            'title' => 't',
        ]);

        $this->assertSame(5, $result->userId);
    }
}
