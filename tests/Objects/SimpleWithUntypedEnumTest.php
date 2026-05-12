<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\Objects;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\DTOWithUntypedEn;
use EntelisTeam\Lbaf\Hydrator\Tests\_dto\Enums\UntypedEnum;
use EntelisTeam\Lbaf\Hydrator\Tests\_traits\CheckObjectTrait;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class SimpleWithUntypedEnumTest extends TestCase
{

    use CheckObjectTrait;

    public function testUntypedEnum(): void
    {
        $instance = new DTOWithUntypedEn();
        $instance->enum = UntypedEnum::GREEN;

        $jsonData = (object)['enum' => 'GREEN'];

        $newInstance = $instance::getHydrator()->hydrateObject($jsonData);

        $this->assertEqualsCanonicalizing($instance, $newInstance);
    }


}
