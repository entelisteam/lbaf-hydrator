<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Mapping;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\Tests\Mapping\_dto\DTOMapCtor;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Hydrator::class)]
final class MapConstructorParamTest extends TestCase
{
    public function testMapOnConstructorParameter(): void
    {
        $result = DTOMapCtor::hydrateObject([
            'user_name' => 'Bob',
        ]);

        $this->assertSame('Bob', $result->userName);
    }
}
