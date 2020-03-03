<?php

namespace Fsm\Collection\Property;

use Fsm\Collection\ImmutableCollection;
use Fsm\Exception\PropertyMissingException;

class PropertyCollection extends ImmutableCollection implements PropertyCollectionInterface
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
