<?php

namespace Fsm\Machine\Transition\Guard;

use Fsm\Machine\StatefulInterface;
use Fsm\Machine\State\StateInterface;
use Fsm\Collection\Argument\ArgumentCollectionInterface;

interface GuardInterface
{
    /**
     * @param StatefulInterface $stateful
     * @param StateInterface $state
     * @param string $to
     * @param ArgumentCollectionInterface|null $arguments
     * @return bool
     */
    function pass(StatefulInterface $stateful, StateInterface $state, string $to, ArgumentCollectionInterface $arguments = null): bool;
}
