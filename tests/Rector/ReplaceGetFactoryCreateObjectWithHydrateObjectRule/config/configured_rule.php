<?php

declare(strict_types=1);

use EntelisTeam\Lbaf\Hydrator\Rector\Migration\Rule\ReplaceGetFactoryCreateObjectWithHydrateObjectRule;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withRules([
        ReplaceGetFactoryCreateObjectWithHydrateObjectRule::class,
    ]);
