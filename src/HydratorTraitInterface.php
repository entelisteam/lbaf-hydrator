<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator;

interface HydratorTraitInterface
{
    public static function getHydrator(): Hydrator;

    public static function hydrateObject(object $object, bool $skipErrors = false, ?string $source = null): static;

    /**
     * @return static[]
     */
    public static function hydrateArray(array $array, bool $skipErrors = false, ?string $source = null): array;
}
