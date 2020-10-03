<?php

namespace Fsm\Machine\Transition\Guard;

use Fsm\Machine\Stateful\StatefulInterface;
use Fsm\Machine\State\State;
use Fsm\Collection\Argument\ArgumentCollection;

interface GuardInterface
{
    /**
     * @param StatefulInterface $stateful
     * @param State $state
     * @param string $to
     * @param ArgumentCollection|null $arguments
     * @return bool
     */
    function pass(StatefulInterface $stateful, State $state, string $to, ArgumentCollection $arguments = null): bool;
}
