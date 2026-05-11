<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Objects;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\DTOHydrator\Tests\_dto\DTOWithConstructorAndLogic;
use EntelisTeam\DTOHydrator\Tests\_traits\CheckObjectTrait;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class SimpleWithConstructorAndLogicTest extends TestCase
{

    use CheckObjectTrait;

    public function testSimpleWithConstructorAndLogic(): void
    {
        $instance = new DTOWithConstructorAndLogic(
            title: 'John',
        );

        $jsonData = (object)['title' => 'John'];

        $newInstance = $instance::getHydrator()->hydrateObject($jsonData);

        $this->assertEqualsCanonicalizing($instance, $newInstance);
    }


}
