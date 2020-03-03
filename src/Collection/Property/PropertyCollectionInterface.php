<?php

namespace Fsm\Collection\Property;

use Fsm\Exception\PropertyMissingException;
use Fsm\Collection\ImmutableCollectionInterface;

interface PropertyCollectionInterface extends ImmutableCollectionInterface
{
    function hasProperty(string $property): bool;

    /**
     * @param string $property
     * @return mixed
     * @throws PropertyMissingException
     */
    function getProperty(string $property);
}
