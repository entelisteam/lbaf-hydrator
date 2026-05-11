<?php

declare(strict_types=1);

use EntelisTeam\DTOHydrator\Rector\Migration\Rule\ReplaceGetFactoryCreateArrayWithHydrateArrayRule;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withRules([
        ReplaceGetFactoryCreateArrayWithHydrateArrayRule::class,
    ]);
