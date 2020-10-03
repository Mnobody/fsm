<?php

namespace Fsm\Machine\State;

use Fsm\Collection\Property\PropertyCollection;

final class State
{
    const TYPE_INITIAL = 'initial';
    const TYPE_INTERMEDIATE = 'intermediate';
    const TYPE_FINAL = 'final';

    private string $name;

    private string $type;

    private ?PropertyCollection $properties = null;

    public function __construct(string $name, string $type, PropertyCollection $properties = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->properties = $properties;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function hasProperties(): bool
    {
        return !is_null($this->properties);
    }

    public function getProperties(): ?PropertyCollection
    {
        return $this->properties;
    }

    public function isInitial(): bool
    {
        return $this->type === self::TYPE_INITIAL;
    }

    public function isIntermediate(): bool
    {
        return $this->type === self::TYPE_INTERMEDIATE;
    }

    public function isFinal(): bool
    {
        return $this->type === self::TYPE_FINAL;
    }

}