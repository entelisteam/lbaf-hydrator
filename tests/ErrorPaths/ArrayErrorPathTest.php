<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\ErrorPaths;

use EntelisTeam\DTOHydrator\Exception\RequiredArgumentException;
use EntelisTeam\DTOHydrator\Hydrator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

class RootArrayItem
{
    public function __construct(
        public string $name
    ) {}
}

class ContainerWithArray
{
    /**
     * @var ItemInArray[]
     */
    #[\EntelisTeam\DTOHydrator\Attribute\ArrayTypeOf(ItemInArray::class)]
    public array $items;
}

class ItemInArray
{
    public function __construct(
        public string $title
    ) {}
}

#[CoversClass(Hydrator::class)]
final class ArrayErrorPathTest extends TestCase
{
    public function testRootArrayMissingField(): void
    {
        $this->expectException(RequiredArgumentException::class);
        $this->expectExceptionMessage('at path: [](RootArrayItem)->name');

        $factory = new Hydrator(RootArrayItem::class);
        $factory->hydrateArray([
            [] // missing 'name' field
        ]);
    }

    public function testNestedArrayMissingField(): void
    {
        $this->expectException(RequiredArgumentException::class);
        $this->expectExceptionMessage('at path: (ContainerWithArray)->items[](ItemInArray)->title');

        $factory = new Hydrator(ContainerWithArray::class);
        $factory->hydrateObject([
            'items' => [
                [] // missing 'title' field
            ]
        ]);
    }
}
