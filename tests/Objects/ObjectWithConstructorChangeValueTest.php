<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Objects;

use EntelisTeam\Lbaf\Hydrator\HydratorRegistry;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_traits\CheckObjectTrait;

final class ObjectWithConstructorChangeValueTest extends TestCase
{

    use CheckObjectTrait;

    public function testSimpleWithConstructor(): void
    {
        $instance = new testDTO(10);

        $json = (object)['i' => 10];
        $newInstance = HydratorRegistry::getHydrator(testDTO::class)->hydrateObject($json);

        $this->assertEqualsCanonicalizing($instance, $newInstance);

        $newInstance = HydratorRegistry::getHydrator(testDTO::class)->hydrateObject(json_decode(json_encode($instance)));
        $this->assertNotEqualsCanonicalizing($instance, $newInstance);
    }

}

class testDTO
{

    use HydratorTrait;

    public int $i;

    public function __construct(int $i)
    {
        $this->i = $i + 1000;
    }
}