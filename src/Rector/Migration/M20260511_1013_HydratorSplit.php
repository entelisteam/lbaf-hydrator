<?php

declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Rector\Migration;

use Rector\Configuration\RectorConfigBuilder;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameStaticMethod;

/**
 * Миграция для downstream-проектов: переход с Lbaf-овских namespace'ов на
 * entelisteam/php-reflection-helpers, entelisteam/php-hydrator и Lbaf\Container\InjectionResolver.
 *
 * Использование в rector.php downstream-проекта:
 *
 *   use Lbaf\Rector\Migration\M20260511_1012_HydratorAndContainerSplit;
 *   use Rector\Config\RectorConfig;
 *
 *   return M20260511_1012_HydratorAndContainerSplit::apply(
 *       RectorConfig::configure()->withPaths([__DIR__ . '/src'])
 *   );
 *
 * Покрывает переименования классов и статических методов. Use-импорты и FQN
 * обновляются автоматически встроенными RenameClassRector и RenameStaticMethodRector.
 */
final class M20260511_1013_HydratorSplit
{
    /**
     * Применяет правила миграции к существующему конфигуратору.
     */
    public static function apply(RectorConfigBuilder $config): RectorConfigBuilder
    {
        return $config
            ->withConfiguredRule(RenameClassRector::class, [
                'Lbaf\\Reflection\\ReflectionClassCreator' => 'EntelisTeam\\DTOHydrator\\Hydrator',
            ])
            ->withConfiguredRule(RenameMethodRector::class, [
                new MethodCallRename('EntelisTeam\\DTOHydrator\\Hydrator', 'createObject', 'hydrateObject'),
                new MethodCallRename('EntelisTeam\\DTOHydrator\\Hydrator', 'createArray', 'hydrateArray'),
            ])
            ->withConfiguredRule(RenameClassRector::class, [
                // Hydrator Engine
                'Lbaf\\Reflection\\ReflectionClassCreator' => 'EntelisTeam\\DTOHydrator\\Internal\\HydratorEngine',
                // Hydrator definitions
                'Lbaf\\Reflection\\Definition\\ClassDefinition' => 'EntelisTeam\\DTOHydrator\\Definition\\ClassDefinition',
                'Lbaf\\Reflection\\Definition\\ArgDefinition' => 'EntelisTeam\\DTOHydrator\\Definition\\ArgDefinition',
                'Lbaf\\Reflection\\Definition\\DefinitionType' => 'EntelisTeam\\DTOHydrator\\Definition\\DefinitionType',
                // Hydrator public facade
                'Lbaf\\Factory\\DTOFactory' => 'EntelisTeam\\DTOHydrator\\Hydrator',
                'Lbaf\\Factory\\DTOFactoryCache' => 'EntelisTeam\\DTOHydrator\\HydratorRegistry',
                'Lbaf\\Factory\\DTOFactoryTrait' => 'EntelisTeam\\DTOHydrator\\HydratorTrait',
                'Lbaf\\Factory\\DTOFactoryTraitInterface' => 'EntelisTeam\\DTOHydrator\\HydratorTraitInterface',

                // Hydrator attribute
                'Lbaf\\Factory\\Attribute\\ArrayTypeOf' => 'EntelisTeam\\DTOHydrator\\Attribute\\ArrayTypeOf',

            ])
            ->withConfiguredRule(RenameStaticMethodRector::class, [
                // Hydrator value coercion
                new RenameStaticMethod('Lbaf\\Reflection\\ReflectionHelper', '_changeInjectValueType', 'EntelisTeam\\DTOHydrator\\Hydrator', 'hydrateValue'),
                new RenameStaticMethod('EntelisTeam\\DTOHydrator\\HydratorRegistry', 'getFactory', 'EntelisTeam\\DTOHydrator\\HydratorRegistry', 'getHydrator'),
            ])
            //импортируем короткие имена через use вместо FQN, удаляем устаревшие use на Lbaf-овские классы
            ->withImportNames(importNames: true, importDocBlockNames: true, importShortClasses: false, removeUnusedImports: true);
    }


}
