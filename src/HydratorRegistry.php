<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator;

class HydratorRegistry
{
    /**
     * @var Hydrator[]
     */
    private static array $hydratorRegistry = [];

    public static function getHydrator(string $className): Hydrator
    {
        if (!isset(self::$hydratorRegistry[$className])) {
            self::$hydratorRegistry[$className] = new Hydrator($className);
        }
        return self::$hydratorRegistry[$className];
    }
}
