<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator;

interface HydratorTraitInterface
{
    public static function getHydrator(): Hydrator;

    public static function hydrateObject(object $object, bool $skipErrors = false): static;

    /**
     * @return static[]
     */
    public static function hydrateArray(array $array, bool $skipErrors = false): array;
}
