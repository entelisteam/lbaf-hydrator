<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\HydratorTraitInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\DTOArrayHeterogeneousWithConstructor;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\DTOArrayHeterogeneousWithConstructorTypedInline;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\Objects\CarDTO;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsArrayFlatHeterogeneous\DTO\Objects\DriverDTO;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class ObjectPropertyisArrayFlatHeterogeneousWithConstructorTest extends TestCase
{

    public function testArray(): void
    {

        $instance = new DTOArrayHeterogeneousWithConstructor([
            DriverDTO::getHydrator()->hydrateObject(['name' => 'Dim', 'age' => 37,]),
            new CarDTO('bmw', 2023, DriverDTO::getHydrator()->hydrateObject(['name' => 'Mark', 'age' => 3,])),
            DriverDTO::getHydrator()->hydrateObject(['name' => 'Alex', 'age' => 35,]),
        ]);

        $this->checkObject($instance);
    }

    public function testArrayTypedInline(): void
    {
        $instance = new DTOArrayHeterogeneousWithConstructorTypedInline([
            DriverDTO::getHydrator()->hydrateObject(['name' => 'Dim', 'age' => 37,]),
            new CarDTO('bmw', 2023, DriverDTO::hydrateObject((object)['name' => 'Mark', 'age' => 3,])),
            DriverDTO::getHydrator()->hydrateObject(['name' => 'Alex', 'age' => 35,]),
        ]);
        $this->checkObject($instance);
    }

    protected function checkObject(object $instance): void
    {
        /**
         * @var HydratorTraitInterface $instance
         */
        $jsonData = json_decode(json_encode($instance));
        $newInstance = $instance::getHydrator()->hydrateObject($jsonData);

        //пришлось убрать assertEqualsCanonicalizing - он пытается сделать sort массива и ломается т.к в массиве объекты
        $this->assertEquals($instance, $newInstance);

        $newInstance = $instance::hydrateObject($jsonData);
        $this->assertEquals($instance, $newInstance);
    }


}
