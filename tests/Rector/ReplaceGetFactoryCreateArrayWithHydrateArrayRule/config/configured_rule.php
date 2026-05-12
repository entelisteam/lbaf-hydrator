<?php

declare(strict_types=1);

use EntelisTeam\Lbaf\Hydrator\Rector\Migration\Rule\ReplaceGetFactoryCreateArrayWithHydrateArrayRule;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withRules([
        ReplaceGetFactoryCreateArrayWithHydrateArrayRule::class,
    ]);
