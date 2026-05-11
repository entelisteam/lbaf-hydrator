<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping;

use EntelisTeam\DTOHydrator\Exception\RequiredArgumentException;
use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\Tests\Mapping\_dto\DTOMapRequired;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapMissingKeyRequiredExceptionTest extends TestCase
{
    public function testRequiredMissingShowsMappedKeyInPath(): void
    {
        $this->expectException(RequiredArgumentException::class);
        $this->expectExceptionMessage('at path: (DTOMapRequired)->userId{user_id}');

        DTOMapRequired::hydrateObject([]);
    }
}
