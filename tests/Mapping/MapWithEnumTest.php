<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Mapping;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\Mapping\_dto\DTOMapEnum;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapWithEnumTest extends TestCase
{
    public function testMapOnEnumProperty(): void
    {
        $result = DTOMapEnum::hydrateObject([
            'color_key' => 'red',
        ]);

        $this->assertSame(StringEnum::RED_COLOR, $result->color);
    }
}
