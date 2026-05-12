<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsDatetime;

use DateTime;
use EntelisTeam\Lbaf\Hydrator\Hydrator;
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;
use EntelisTeam\Lbaf\Hydrator\HydratorTraitInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use EntelisTeam\Lbaf\Hydrator\Tests\ObjectPropertyIsDatetime\Objects\DTODatetimeWithConstructor;


#[
    CoversClass(Hydrator::class),
    CoversClass(HydratorTrait::class),
]
final class ObjectPropertyIsDatetimeTest extends TestCase
{

    public static function datetimeProvider(): array
    {
        return [
            [
                'json' => (object)[
                    'title' => 'title',
                    'dateTimeRequired' => (object)['datetime' => '2023-10-01 10:15:00'],
                    'dateTimeNullable' => null,
                ],
                'instance' => new DTODatetimeWithConstructor(
                    'title',
                    new DateTime('2023-10-01 10:15:00'),
                    null,
                )
            ],
            [
                'json' => (object)[
                    'title' => 'title',
                    'dateTimeRequired' => (object)['datetime' => '2023-10-01 10:15:00'],
                    #'dateTimeNullable' => null, //optional
                ],
                'instance' => new DTODatetimeWithConstructor(
                    'title',
                    new DateTime('2023-10-01 10:15:00'),
                    null,
                )
            ],
            [
                'json' => (object)[
                    'title' => 'title',
                    'dateTimeRequired' => '2023-10-01 10:15:55',
                    'dateTimeNullable' => '2023-10-01 10:30:11',
                ],
                'instance' => new DTODatetimeWithConstructor(
                    'title',
                    new DateTime('2023-10-01 10:15:55'),
                    new DateTime('2023-10-01 10:30:11'),
                )
            ],
            [
                'json' => (object)[
                    'title' => 'title',
                    'dateTimeRequired' => '2023-10-01 10:15:55',
                    'dateTimeNullable' => '2023-10-01 10:30:11',
                ],
                'instance' => new DTODatetimeWithConstructor(
                    'title',
                    new DateTime('2023-10-01 10:15:55'),
                    new DateTime('2023-10-01 10:30:11'),
                )
            ],
            [
                'json' => (object)[
                    'title' => 'title',
                    'dateTimeRequired' => '2023-10-01 10:15:55',
                    'dateTimeNullable' => '2023-10-01 10:30:11',
                ],
                'instance' => new DTODatetimeWithConstructor(
                    'title',
                    new DateTime('2023-10-01 10:15:55'),
                    new DateTime('2023-10-01 10:30:11'),
                )
            ],
            [
                'json' => (object)[
                    'title' => 'title',
                    'dateTimeRequired' => '2023-10-01 10:15:55',
                    'dateTimeNullable' => '2023-10-01 10:30:11',
                ],
                'instance' => new DTODatetimeWithConstructor(
                    'title',
                    new DateTime('2023-10-01 10:15:55'),
                    new DateTime('2023-10-01 10:30:11'),
                )
            ],

            [
                'json' => json_decode(json_encode(new DTODatetimeWithConstructor(
                    'title',
                    new DateTime('2023-10-01 10:15:55'),
                    new DateTime('2023-10-01 10:30:11'),
                ))),
                'instance' => new DTODatetimeWithConstructor(
                    'title',
                    new DateTime('2023-10-01 10:15:55'),
                    new DateTime('2023-10-01 10:30:11'),
                )
            ],

            [
                'json' => json_decode(json_encode(new DTODatetimeWithConstructor(
                    'title',
                    new DateTime('2023-10-01 10:15:55'),
                    null,
                ))),
                'instance' => new DTODatetimeWithConstructor(
                    'title',
                    new DateTime('2023-10-01 10:15:55'),
                    null,
                )
            ],

        ];
    }

    #[
        DataProvider('datetimeProvider')
    ]
    public function testDatetime(object $json, HydratorTraitInterface $instance): void
    {

        /**
         * @var HydratorTraitInterface $instance
         */
        $newInstance = $instance::getHydrator()->hydrateObject($json);
        $this->assertEqualsCanonicalizing($instance, $newInstance);

    }


}
