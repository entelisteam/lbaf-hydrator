<?php

namespace EntelisTeam\DTOHydrator\Tests\ComplexObjects\_testObjects;

use EntelisTeam\DTOHydrator\Attribute\ArrayTypeOf;
use EntelisTeam\DTOHydrator\HydratorTrait;

class StoryPage
{
    use HydratorTrait;

    // указание тут ArrayTypeOf - ключевой момент для сборки
    #[
        ArrayTypeOf(
            'content',
            [
                TextContent::class,
                ImageContent::class,
                TitleContent::class,
            ]
        ),
    ]
    /**
     * @var TextContent[]|ImageContent[]|TitleContent[] $content
     */
    function __construct(public string $title, public array $content)
    {
    }
}
