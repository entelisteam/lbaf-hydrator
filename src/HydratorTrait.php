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

    public static function hydrateObject(object|array $object, bool $skipErrors = false, ?string $source = null): static
    {
        return static::getHydrator()->hydrateObject($object, $skipErrors, $source);
    }

    /**
     * @return static[]
     */
    public static function hydrateArray(array $array, bool $skipErrors = false, ?string $source = null): array
    {
        return static::getHydrator()->hydrateArray($array, $skipErrors, $source);
    }
}
