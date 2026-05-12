<?php

declare(strict_types=1);

use EntelisTeam\Lbaf\Hydrator\Rector\Migration\M20260612_1930_HydratorCallUnification;
use Rector\Config\RectorConfig;

return M20260612_1930_HydratorCallUnification::apply(RectorConfig::configure());
