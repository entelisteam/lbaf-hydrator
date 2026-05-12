<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Objects;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\DTOWithConstructorAndLogic;
use EntelisTeam\Lbaf\Hydrator\Tests\_traits\CheckObjectTrait;

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
