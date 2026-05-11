<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping;

use EntelisTeam\DTOHydrator\Exception\RequiredArgumentException;
use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\Tests\Mapping\_dto\DTOOuter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapNestedObjectMissingMappedKeyErrorTest extends TestCase
{
    public function testMissingMappedChildOnParentErrorPath(): void
    {
        $this->expectException(RequiredArgumentException::class);
        $this->expectExceptionMessage('at path: (DTOOuter)->child{child_old}');

        DTOOuter::hydrateObject([], false, 'old');
    }

    public function testMissingMappedFieldInsideChildErrorPath(): void
    {
        $this->expectException(RequiredArgumentException::class);
        $this->expectExceptionMessage('at path: (DTOOuter)->child{child_old}(DTOInner)->innerValue{inner_old}');

        DTOOuter::hydrateObject([
            'child_old' => [],
        ], false, 'old');
    }

    public function testMissingMappedFieldInsideChildNoSourceErrorPath(): void
    {
        $this->expectException(RequiredArgumentException::class);
        $this->expectExceptionMessage('at path: (DTOOuter)->child{child_default}(DTOInner)->innerValue{inner_default}');

        DTOOuter::hydrateObject([
            'child_default' => [],
        ]);
    }
}
