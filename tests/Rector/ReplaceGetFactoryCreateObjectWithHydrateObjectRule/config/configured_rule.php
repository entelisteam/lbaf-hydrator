<?php

declare(strict_types=1);

use EntelisTeam\DTOHydrator\Rector\Migration\Rule\ReplaceGetFactoryCreateObjectWithHydrateObjectRule;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withRules([
        ReplaceGetFactoryCreateObjectWithHydrateObjectRule::class,
    ]);
