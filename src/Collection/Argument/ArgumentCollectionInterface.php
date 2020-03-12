<?php

namespace Fsm\Collection\Argument;

use Fsm\Collection\ImmutableCollectionInterface;
use Fsm\Exception\ArgumentMissingException;

interface ArgumentCollectionInterface extends ImmutableCollectionInterface
{
    function hasArgument(string $argument): bool;

    /**
     * @param string $argument
     * @return mixed
     * @throws ArgumentMissingException
     */
    function getArgument(string $argument);
}
