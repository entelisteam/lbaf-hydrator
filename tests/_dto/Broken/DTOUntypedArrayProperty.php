<?php

namespace EntelisTeam\DTOHydrator\Tests\_dto\Broken;

use EntelisTeam\DTOHydrator\HydratorTrait;

class DTOUntypedArrayProperty
{
    use HydratorTrait;

    public array $arr;

}
