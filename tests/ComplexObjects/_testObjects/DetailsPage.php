<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects;

use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

class DetailsPage
{
    use HydratorTrait;

    function __construct(public string $title, public TextContent|ImageContent|TitleContent $content)
    {
    }
}
