<?php

declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Rector;

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
            Migration\M20260512_1845_NamespaceUnification::class,
            Migration\M20260612_1930_HydratorCallUnification::class,
        ];
    }
}
