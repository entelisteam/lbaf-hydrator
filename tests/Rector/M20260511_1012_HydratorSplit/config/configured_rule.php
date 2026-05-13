<?php

declare(strict_types=1);

use EntelisTeam\Lbaf\Hydrator\Rector\Migration\Migration_20260511_1013_HydratorSplit;
use Rector\Config\RectorConfig;

return Migration_20260511_1013_HydratorSplit::apply(RectorConfig::configure());
