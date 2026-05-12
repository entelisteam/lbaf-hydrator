<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Definition;

enum DefinitionType
{
    case SIMPLE;
    case ARRAY;
    case OBJECT;
    case ENUM;
}
