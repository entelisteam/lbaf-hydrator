<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator;

trait HydratorTrait
{
    public static function getHydrator(): Hydrator
    {
        //единый реестр гидраторов, неважно из какого класса вызван
        return HydratorRegistry::getHydrator(static::class);
    }

    public static function hydrateObject(object|array $object, bool $skipErrors = false): static
    {
        return static::getHydrator()->hydrateObject($object, $skipErrors);
    }

    /**
     * @return static[]
     */
    public static function hydrateArray(array $array, bool $skipErrors = false): array
    {
        return static::getHydrator()->hydrateArray($array, $skipErrors);
    }
}
