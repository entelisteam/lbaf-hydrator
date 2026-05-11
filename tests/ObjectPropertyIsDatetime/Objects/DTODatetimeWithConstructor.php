<?php

namespace EntelisTeam\DTOHydrator\Tests\ObjectPropertyIsDatetime\Objects;

use DateTime;
use EntelisTeam\DTOHydrator\HydratorTrait;
use EntelisTeam\DTOHydrator\HydratorTraitInterface;

class DTODatetimeWithConstructor implements HydratorTraitInterface
{

    use HydratorTrait;

    public function __construct(
        public string    $title,
        public DateTime  $dateTimeRequired,
        public ?DateTime $dateTimeNullable,
        public ?DateTime $dateTimeNullableIsNull = null
    )
    {
    }
}