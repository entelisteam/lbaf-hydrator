<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\Tests\Mapping\_dto\DTOMapPromoted;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapPromotedPropTest extends TestCase
{
    public function testMapOnPromotedConstructorProperty(): void
    {
        $result = DTOMapPromoted::hydrateObject([
            'full_name' => 'Bob Doe',
        ]);

        $this->assertSame('Bob Doe', $result->fullName);
    }
}
