<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto\DTOMapMixed;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapExplicitSourceWinsOverNullTest extends TestCase
{
    public function testExplicitSourceOverridesNullMap(): void
    {
        $result = DTOMapMixed::hydrateObject([
            'value_old' => 'OLD',
            'value_default' => 'DEF',
        ], false, 'old');

        $this->assertSame('OLD', $result->value);
    }
}
