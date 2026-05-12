<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator\Tests\_traits;

use EntelisTeam\Lbaf\Hydrator\HydratorTraitInterface;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

trait CheckObjectTrait
{

    protected function checkObject(object $instance): void
    {
        /**
         * @var HydratorTraitInterface $instance
         * @var TestCase|Assert $this
         * @var  $this
         */
        $jsonData = json_decode(json_encode($instance));
        $newInstance = $instance::getHydrator()->hydrateObject($jsonData);

        $this->assertEqualsCanonicalizing($instance, $newInstance);

        //check creation from object
        $newInstance = $instance::hydrateObject($jsonData);
        $this->assertEqualsCanonicalizing($instance, $newInstance);

        //check array
        $arrayJsonData = [
            $jsonData,
            $jsonData,
            $jsonData,
        ];

        $newArray =  $instance::getHydrator()->hydrateArray($arrayJsonData);
        $this->assertIsArray($newArray);
        $this->assertCount(3, $newArray);
        foreach ($newArray as $object) {
            $this->assertEqualsCanonicalizing($instance, $object);
        }

        $newArray =  $instance::hydrateArray($arrayJsonData);
        $this->assertIsArray($newArray);
        $this->assertCount(3, $newArray);
        foreach ($newArray as $object) {
            $this->assertEqualsCanonicalizing($instance, $object);
        }

    }


}
