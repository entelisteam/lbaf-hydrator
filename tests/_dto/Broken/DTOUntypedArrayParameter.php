<?php

namespace EntelisTeam\DTOHydrator\Tests\_dto\Broken;

use EntelisTeam\DTOHydrator\HydratorTrait;

class DTOUntypedArrayParameter
{

    use HydratorTrait;

    public function __construct(public array $arr)
    {
    }

}
