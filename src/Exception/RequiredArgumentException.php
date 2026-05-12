<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Exception;

use ReflectionParameter;
use ReflectionProperty;

class RequiredArgumentException extends HydrationException
{
    public function __construct(
        public readonly ReflectionParameter|ReflectionProperty $param,
        public readonly string $path = '',
    ) {
        $message = 'Required argument "' . $param->getName() . '" (' . $param->getType()->getName() . ') is missing or invalid';
        if ($path !== '') {
            $message .= ' at path: ' . $path;
        }
        parent::__construct($message);
    }
}
