<?php

namespace Fsm\Machine\Transition\Callback;

use Fsm\Machine\StatefulInterface;
use Fsm\Machine\State\StateInterface;
use Fsm\Collection\Argument\ArgumentCollectionInterface;

interface CallbackInterface
{
    /**
     * Handles callback after transition form state '$state' to state '$to'
     *
     * @param StatefulInterface $stateful
     * @param StateInterface $state
     * @param string $to
     * @param ArgumentCollectionInterface|null $arguments
     * @return mixed
     */
    function handle(StatefulInterface $stateful, StateInterface $state, string $to, ArgumentCollectionInterface $arguments = null);
}
