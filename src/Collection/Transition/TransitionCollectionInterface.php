<?php

namespace Fsm\Collection\Transition;

use Fsm\Machine\Transition\TransitionInterface;
use Fsm\Exception\TransitionMissingException;
use Fsm\Collection\ImmutableCollectionInterface;

interface TransitionCollectionInterface extends ImmutableCollectionInterface
{
    /**
     * @param string $name
     * @return TransitionInterface
     * @throws TransitionMissingException
     */
    function getTransition(string $name): TransitionInterface;
}
