<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping;

use EntelisTeam\DTOHydrator\Exception\RequiredArgumentException;
use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\Tests\Mapping\_dto\DTOMapArraySourced;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapArrayOfObjectsMissingMappedKeyErrorTest extends TestCase
{
    public function testMissingMappedKeyOnContainerErrorPath(): void
    {
        $this->expectException(RequiredArgumentException::class);
        $this->expectExceptionMessage('at path: (DTOMapArraySourced)->items{items_list}');

        DTOMapArraySourced::hydrateObject([], false, 'old');
    }

    public function testMissingMappedKeyInsideElementErrorPath(): void
    {
        $this->expectException(RequiredArgumentException::class);
        $this->expectExceptionMessage('at path: (DTOMapArraySourced)->items{items_list}[](DTOItemSourced)->name{name_old}');

        DTOMapArraySourced::hydrateObject([
            'items_list' => [
                [],
            ],
        ], false, 'old');
    }
}
