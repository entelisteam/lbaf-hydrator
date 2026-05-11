<?php

namespace Tests\Rector\M20260511_1012_HydratorAndContainerSplit\Fixture;

use Lbaf\Reflection\ReflectionClassCreator;

class UsesReflectionClassCreator
{
    public function build(string $class, object $data): object
    {
        return ReflectionClassCreator::createClassFromData($class, $data, false);
    }
}

?>
-----
<?php

namespace Tests\Rector\M20260511_1012_HydratorAndContainerSplit\Fixture;

use EntelisTeam\DTOHydrator\Internal\HydratorEngine;

class UsesReflectionClassCreator
{
    public function build(string $class, object $data): object
    {
        return HydratorEngine::createClassFromData($class, $data, false);
    }
}

?>
