<?php

declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Rector;

/**
 * Реестр Rector-миграций пакета entelisteam/php-dto-hydrator.
 */
final class Migrations
{
    /**
     * @return list<class-string>
     */
    public static function all(): array
    {
        return [
            Migration\M20260511_1013_HydratorSplit::class,
            Migration\M20260511_1500_DTOFactoryToHydrator::class,
        ];
    }
}
