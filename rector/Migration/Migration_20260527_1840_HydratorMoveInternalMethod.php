<?php

declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Rector\Migration;

use Rector\Configuration\RectorConfigBuilder;
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\ValueObject\RenameStaticMethod;

/**
 * Миграция: EntelisTeam\Lbaf\Hydrator\Hydrator::hydrateValue
 *         → EntelisTeam\Lbaf\Hydrator\Internal\HydratorEngine::hydrateValue
 */
final class Migration_20260527_1840_HydratorMoveInternalMethod
{
    public static function apply(RectorConfigBuilder $config): RectorConfigBuilder
    {
        return $config
            ->withConfiguredRule(RenameStaticMethodRector::class, [
                new RenameStaticMethod(
                    'EntelisTeam\\Lbaf\\Hydrator\\Hydrator',
                    'hydrateValue',
                    'EntelisTeam\\Lbaf\\Hydrator\\Internal\\HydratorEngine',
                    'hydrateValue',
                ),
            ])
            ->withImportNames(importNames: true, importDocBlockNames: true, importShortClasses: false, removeUnusedImports: true);
    }
}
