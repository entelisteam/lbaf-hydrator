<?php

namespace EntelisTeam\DTOHydrator\Tests\ComplexObjects\_testObjects;

use EntelisTeam\DTOHydrator\HydratorTrait;

class DetailsPage2
{
    use HydratorTrait;

    public string $title;
    public TextContent|ImageContent|TitleContent $content;

    //для удобства написания тестов
    function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    //для удобства написания тестов
    function setContent(TextContent|ImageContent|TitleContent $content): self
    {
        $this->content = $content;
        return $this;
    }
}
