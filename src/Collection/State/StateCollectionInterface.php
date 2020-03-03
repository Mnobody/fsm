<?php

namespace Fsm\Collection\State;

use Fsm\Machine\State\StateInterface;
use Fsm\Exception\StateMissingException;
use Fsm\Collection\ImmutableCollectionInterface;

interface StateCollectionInterface extends ImmutableCollectionInterface
{
    function getInitial(): StateInterface;

    /**
     * @param string $name
     * @return StateInterface
     * @throws StateMissingException
     */
    function getState(string $name): StateInterface;
}
