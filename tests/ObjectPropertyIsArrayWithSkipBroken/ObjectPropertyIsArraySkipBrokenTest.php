<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayWithSkipBroken;

use EntelisTeam\Lbaf\Hydrator\Exception\RequiredArgumentException;
use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\StringEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayWithSkipBroken\DTO\TestItem;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayWithSkipBroken\DTO\TestObjectWithArrayProperty;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class ObjectPropertyIsArraySkipBrokenTest extends TestCase
{

    public static function provider(): array
    {
        return [
            [self::getTest('aaa')],
            [self::getTest((object)['id' => null, 'name' => 'Jane', 'type' => StringEnum::BLUE_COLOR])],
            [self::getTest((object)['name' => 'Jane'])],
            [self::getTest((object)['id' => 2, 'name' => 'Jane', 'type' => 'ololo'])],
        ];
    }

    protected static function getTest(mixed $bad = null): TestObjectWithArrayProperty
    {
        $targetObject = new TestObjectWithArrayProperty();
        $targetObject->items = [];

        $targetObject->items[] = new TestItem(1, 'Alex', StringEnum::BLUE_COLOR);
        if ($bad !== null) {
            $targetObject->items[] = $bad;
        }
        $targetObject->items[] = new TestItem(3, 'Mike', StringEnum::GREEN_COLOR);
        return $targetObject;
    }


    #[DataProvider('provider')]
    public function testException(object $jsonData): void
    {
        $this->expectException(RequiredArgumentException::class);
        TestObjectWithArrayProperty::getHydrator()->hydrateObject(json_decode(json_encode($jsonData)));
    }

    #[DataProvider('provider')]
    public function testSuccess(object $jsonData): void
    {
        $targetInstance = self::getTest();
        $newInstance = TestObjectWithArrayProperty::getHydrator()->hydrateObject(
            json_decode(json_encode($jsonData)),
            true,
        );

        $this->assertEqualsCanonicalizing($targetInstance, $newInstance);
    }


}
