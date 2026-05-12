<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects;

use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\_traits\CheckObjectTrait;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\DetailsPage;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\DetailsPage2;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\DetailsPage3;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\ImageContent;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\ImageContentData;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\PolyContent;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\TextContent;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\TextContentData;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\TitleContent;
use EntelisTeam\Lbaf\Hydrator\Tests\ComplexObjects\_testObjects\TitleContentData;

#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class ObjectPropertyIsClassUnionTest extends TestCase
{
    use CheckObjectTrait;

    /**
     * Проверяем кейс когда полиморфный объект лежит не в массиве, а в свойстве
     */
    #[
        DataProvider('dataProvider'),
    ]
    public function testClassUnion($instance): void
    {
        $this->checkObject($instance);
    }

    public static function dataProvider(): array
    {
        return [
            ['instance' => new PolyContent('text', (object)['text' => 'header'])],
            ['instance' => new PolyContent('null', null)],
            ['instance' => new PolyContent('text', new TextContentData('header'))], //получается некоторая тавтология, но работает
            ['instance' => new DetailsPage('test1', new TitleContent(TitleContent::TYPE, new TitleContentData('The best header in the world')))],
            ['instance' => new DetailsPage('test2', new ImageContent(ImageContent::TYPE, new ImageContentData('https://mydomain.com/image.png', 111_000)))],
            ['instance' => new DetailsPage('test3', new TextContent(TextContent::TYPE, new TextContentData('loremipsum page 2')))],
            ['instance' => (new DetailsPage2())->setTitle('test title')->setContent(new TitleContent(TitleContent::TYPE, new TitleContentData('The best header in the world')))],
            ['instance' => (new DetailsPage2())->setTitle('test title')->setContent(new ImageContent(ImageContent::TYPE, new ImageContentData('https://mydomain.com/image.png', 111_000)))],
            ['instance' => (new DetailsPage2())->setTitle('test title')->setContent(new TextContent(TextContent::TYPE, new TextContentData('loremipsum page 3')))],
        ];

    }

}
