<?php

declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Rector\Migration;


use Rector\Configuration\RectorConfigBuilder;
use Rector\Renaming\Rector\Name\RenameClassRector;

/**
 * Миграция: EntelisTeam\DTOHydrator -> EntelisTeam\Lbaf\Hydrator
 */
final class M20260512_1845_NamespaceUnification
{
    public static function apply(RectorConfigBuilder $config): RectorConfigBuilder
    {

        $classList = [
            'Attribute\\ArrayTypeOf',
            'Attribute\\Map',
            'Definition\\ArgDefinition',
            'Definition\\ClassDefinition',
            'Definition\\DefinitionType',
            'Exception\\ArgumentTypeException',
            'Exception\\HydrationException',
            'Exception\\RequiredArgumentException',
            'Internal\\HydratorEngine',
            'Hydrator',
            'HydratorRegistry',
            'HydratorTrait',
            'HydratorTraitInterface',
        ];

        $classRenames = [];
        foreach ($classList as $class) {
            $classRenames['EntelisTeam\\DTOHydrator\\' . $class] = 'EntelisTeam\\Lbaf\\Hydrator\\' . $class;
        }

        return $config
            ->withConfiguredRule(RenameClassRector::class, $classRenames)
            ->withImportNames(importNames: true, importDocBlockNames: true, importShortClasses: false, removeUnusedImports: true);
    }
}
