<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\_dto\Broken;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class DTOUntypedArrayParameter
{

    use HydratorTrait;

    public function __construct(public array $arr)
    {
    }

}
