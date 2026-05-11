<?php

namespace EntelisTeam\DTOHydrator\Tests\ComplexObjects\_testObjects;

use EntelisTeam\DTOHydrator\HydratorTrait;

class PolyContent
{
    use HydratorTrait;

    public ImageContentData|TextContentData|TitleContentData|null $data;

    function __construct(public string $type, mixed $data)
    {
        $this->data = match ($type) {
            'image' => ImageContentData::getHydrator()->hydrateObject($data),
            'text'  => TextContentData::getHydrator()->hydrateObject($data),
            'title' => TitleContentData::getHydrator()->hydrateObject($data),
            'null'  => null,
            default => throw new \Exception('unsupported'),
        };
    }
}