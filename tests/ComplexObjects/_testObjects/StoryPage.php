<?php

namespace EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects;

use EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

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
