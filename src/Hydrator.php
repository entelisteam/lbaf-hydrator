<?php
declare(strict_types=1);

namespace EntelisTeam\Lbaf\Hydrator;

use EntelisTeam\Lbaf\Reflection\ClassNameHelper;
use EntelisTeam\Lbaf\Hydrator\Exception\RequiredArgumentException;
use EntelisTeam\Lbaf\Hydrator\Internal\HydratorEngine;

class Hydrator
{
    public function __construct(protected string $className)
    {
    }

    /**
     * Создает экземпляр объекта на основе данных в структуре $jsonData.
     * @throws RequiredArgumentException
     */
    public function hydrateObject(object|array $jsonData, bool $skipErrorsInArrayCreation = false, ?string $source = null, string $path = ''): ?object
    {
        if (is_array($jsonData)) {
            $jsonData = (object)$jsonData;
        }
        return HydratorEngine::createClassFromData(
            $this->className,
            $jsonData,
            $skipErrorsInArrayCreation,
            $path,
            $source
        );
    }

    /**
     * Создает массив объектов на основе данных в структуре $jsonData.
     */
    public function hydrateArray(array $jsonDataArray, bool $skipErrorsInArrayCreation = false, ?string $source = null): array
    {
        $result = [];
        foreach ($jsonDataArray as $index => $item) {
            try {
                $result[] = $this->hydrateObject($item, $skipErrorsInArrayCreation, $source, '[](' . ClassNameHelper::getShortClassName($this->className) . ')');
            } catch (RequiredArgumentException $e) {
                if ($skipErrorsInArrayCreation) {
                    continue;
                }
                throw $e;
            }
        }
        return $result;
    }

}
