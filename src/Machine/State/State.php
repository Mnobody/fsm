<?php

namespace Fsm\Machine\State;

use Fsm\Collection\Property\PropertyCollectionInterface;

final class State implements StateInterface
{
    const TYPE_INITIAL = 'initial';
    const TYPE_INTERMEDIATE = 'intermediate';
    const TYPE_FINAL = 'final';

    private string $name;

    private string $type;

    private ?PropertyCollectionInterface $properties = null;

    public function __construct(string $name, string $type, ?PropertyCollectionInterface $properties = null)
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

    public function getProperties(): ?PropertyCollectionInterface
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