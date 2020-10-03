<?php

namespace Fsm\Collection\Property;

use Fsm\Collection\ImmutableCollection;
use Fsm\Exception\PropertyMissingException;

final class PropertyCollection extends ImmutableCollection
{
    public function getProperty(string $property)
    {
        if (!$this->hasProperty($property)) {
            throw new PropertyMissingException("The property: '$property' does not exists.");
        }

        return $this->items[$property];
    }

    public function hasProperty(string $property): bool
    {
        return isset($this->items[$property]);
    }
}
