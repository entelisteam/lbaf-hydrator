<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Definition;

use ReflectionParameter;
use ReflectionProperty;

class ArgDefinition
{
    public string $title;

    /**
     * Типизация типа: простой тип / enum / объект / массив
     */
    public DefinitionType $definitionType;

    /**
     * @var string|string[]
     */
    public string|array $argType;

    public mixed $defaultValue;
    public bool $mustBeOverwritten;
    public ReflectionProperty|ReflectionParameter $reflection;

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setDefinitionType(DefinitionType $definitionType): self
    {
        $this->definitionType = $definitionType;
        return $this;
    }

    public function setArgType(string $argType): self
    {
        $this->argType = $argType;
        return $this;
    }

    public function setDefaultValue(mixed $defaultValue): self
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function setMustBeOverwritten(bool $mustBeOverwritten): self
    {
        $this->mustBeOverwritten = $mustBeOverwritten;
        return $this;
    }

    public function setReflection(ReflectionProperty|ReflectionParameter $reflection): self
    {
        $this->reflection = $reflection;
        return $this;
    }
}
