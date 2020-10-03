<?php

namespace Fsm\Machine\Transition\Callback;

use Fsm\Machine\Stateful\StatefulInterface;
use Fsm\Machine\State\State;
use Fsm\Collection\Argument\ArgumentCollection;

interface CallbackInterface
{
    /**
     * Handles callback after transition form state '$state' to state '$to'
     *
     * @param StatefulInterface $stateful
     * @param State $state
     * @param string $to
     * @param ArgumentCollection|null $arguments
     * @return mixed
     */
    function handle(StatefulInterface $stateful, State $state, string $to, ArgumentCollection $arguments = null);
}
