<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Exception;

class ArgumentTypeException extends HydrationException
{
    public function __construct(
        string $message,
        public readonly string $path = '',
    ) {
        if ($path !== '') {
            $message .= ' at path: ' . $path;
        }
        parent::__construct($message);
    }
}
