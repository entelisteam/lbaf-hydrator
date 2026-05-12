<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_traits\CheckObjectTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\ImageContent;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\ImageContentData;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\StoryPage;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\TextContent;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\TextContentData;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\TitleContent;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\TitleContentData;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class ObjectPropertyIsHeterogeneousArrayTest extends TestCase
{
    use CheckObjectTrait;

    /**
     * Проверяем кейс когда тип одного параметра зависит от другого
     */
    public function testComplexPolymorph(): void
    {
        $instance = new StoryPage('first page', [
            new TitleContent(TitleContent::TYPE, new TitleContentData('The best header in the world')),
            new ImageContent(ImageContent::TYPE, new ImageContentData('https://mydomain.com/image.png', 111_000)),
            new TextContent(TextContent::TYPE, new TextContentData('loremipsum page 1')),
            new TextContent(TextContent::TYPE, new TextContentData('loremipsum page 2')),
        ]);

        $this->checkObject($instance);
    }

    //@todo кейс когда полиморфный объект лежит не в массиве, а в свойстве

}
