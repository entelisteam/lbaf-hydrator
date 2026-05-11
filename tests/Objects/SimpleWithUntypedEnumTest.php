<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Tests\Objects;

use EntelisTeam\DTOHydrator\Hydrator;
use EntelisTeam\DTOHydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\DTOHydrator\Tests\_dto\DTOWithUntypedEn;
use EntelisTeam\DTOHydrator\Tests\_dto\Enums\UntypedEnum;
use EntelisTeam\DTOHydrator\Tests\_traits\CheckObjectTrait;

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
