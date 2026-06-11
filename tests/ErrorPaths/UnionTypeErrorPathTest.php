<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\ErrorPaths;

use EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf;
use EntelisTeam\Lbaf\Hydrator\Exception\RequiredArgumentException;
use EntelisTeam\Lbaf\Hydrator\Hydrator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

class ContainerWithUnion
{
    public function __construct(
        public TypeA|TypeB $content
    ) {}
}

class TypeA
{
    public function __construct(
        public string $fieldA
    ) {}
}

class TypeB
{
    public function __construct(
        public string $fieldB
    ) {}
}

class DeepUnionContainer
{
    public function __construct(
        public NestedUnion $nested
    ) {}
}

class NestedUnion
{
    /**
     * @var UnionItemA[]|UnionItemB[]
     */
    #[ArrayTypeOf([UnionItemA::class, UnionItemB::class])]
    public array $items;
}

class UnionItemA
{
    public function __construct(
        public string $valueA
    ) {}
}

class UnionItemB
{
    public function __construct(
        public string $valueB
    ) {}
}

#[CoversClass(Hydrator::class)]
final class UnionTypeErrorPathTest extends TestCase
{
    public function testUnionTypeMissingField(): void
    {
        $this->expectException(RequiredArgumentException::class);
        // Union will try last type (TypeB) when both fail
        $this->expectExceptionMessage('at path: (ContainerWithUnion)->content(TypeB)->fieldB');

        $factory = new Hydrator(ContainerWithUnion::class);
        $factory->hydrateObject([
            'content' => [] // missing both fieldA and fieldB
        ]);
    }

    public function testUnionTypeInArrayMissingField(): void
    {
        $this->expectException(RequiredArgumentException::class);
        // Union will try last type (UnionItemB) when both fail
        $this->expectExceptionMessage('at path: (DeepUnionContainer)->nested(NestedUnion)->items[](UnionItemB)->valueB');

        $factory = new Hydrator(DeepUnionContainer::class);
        $factory->hydrateObject([
            'nested' => [
                'items' => [
                    [] // missing both valueA and valueB
                ]
            ]
        ]);
    }
}
