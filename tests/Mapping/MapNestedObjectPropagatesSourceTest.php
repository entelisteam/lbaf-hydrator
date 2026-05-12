<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto\DTOOuter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapNestedObjectPropagatesSourceTest extends TestCase
{
    public function testSourcePropagatesToNestedObject(): void
    {
        $result = DTOOuter::hydrateObject([
            'child_old' => [
                'inner_old' => 'deep',
            ],
        ], false, 'old');

        $this->assertSame('deep', $result->child->innerValue);
    }

    public function testNoSourcePropagatesToNestedObject(): void
    {
        $result = DTOOuter::hydrateObject([
            'child_default' => [
                'inner_default' => 'shallow',
            ],
        ]);

        $this->assertSame('shallow', $result->child->innerValue);
    }
}
