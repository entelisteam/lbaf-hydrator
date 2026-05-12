<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsDatetime\Objects;

use DateTime;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\HydratorTraitInterface;

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