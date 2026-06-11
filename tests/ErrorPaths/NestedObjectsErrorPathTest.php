<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\ErrorPaths;

use EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf;
use EntelisTeam\Lbaf\Hydrator\Exception\RequiredArgumentException;
use EntelisTeam\Lbaf\Hydrator\Hydrator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

class Foo
{
    public function __construct(
        public Bar $test1
    ) {}
}

class Bar
{
    /**
     * @var Zoo[]
     */
    #[ArrayTypeOf(Zoo::class)]
    public array $items;
}

class Zoo
{
    public function __construct(
        public string $required
    ) {}
}

class SimpleNested
{
    public function __construct(
        public DeepNested $nested
    ) {}
}

class DeepNested
{
    public function __construct(
        public string $value
    ) {}
}

#[CoversClass(Hydrator::class)]
final class NestedObjectsErrorPathTest extends TestCase
{
    public function testNestedObjectMissingRequiredField(): void
    {
        $this->expectException(RequiredArgumentException::class);
        $this->expectExceptionMessage('at path: (Foo)->test1(Bar)->items[](Zoo)->required');

        $factory = new Hydrator(Foo::class);
        $factory->hydrateObject([
            'test1' => [
                'items' => [
                    [] // missing 'required' field in Zoo
                ]
            ]
        ]);
    }

    public function testSimpleNestedObjectMissingField(): void
    {
        $this->expectException(RequiredArgumentException::class);
        $this->expectExceptionMessage('at path: (SimpleNested)->nested(DeepNested)->value');

        $factory = new Hydrator(SimpleNested::class);
        $factory->hydrateObject([
            'nested' => [] // missing 'value' field
        ]);
    }

    public function testRootLevelMissingField(): void
    {
        $this->expectException(RequiredArgumentException::class);
        $this->expectExceptionMessage('at path: (Foo)->test1');

        $factory = new Hydrator(Foo::class);
        $factory->hydrateObject([
            // missing 'test1' field
        ]);
    }
}
