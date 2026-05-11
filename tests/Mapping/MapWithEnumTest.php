<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\StringEnum;
use EntelisTeam\DTOHydrator\Tests\Mapping\_dto\DTOMapEnum;
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
