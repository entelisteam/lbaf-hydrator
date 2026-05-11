<?php

namespace EntelisTeam\DTOHydrator\Tests\ComplexObjects\_testObjects;

use EntelisTeam\DTOHydrator\HydratorTrait;

class DetailsPage
{
    use HydratorTrait;

    function __construct(public string $title, public TextContent|ImageContent|TitleContent $content)
    {
    }
}
