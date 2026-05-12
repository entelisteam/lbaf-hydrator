<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto\DTOMapProperty;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapPropertyTest extends TestCase
{
    public function testMapOnPublicProperty(): void
    {
        $result = DTOMapProperty::hydrateObject([
            'user_id' => 7,
            'title' => 'hello',
        ]);

        $this->assertSame(7, $result->userId);
        $this->assertSame('hello', $result->title);
    }
}
