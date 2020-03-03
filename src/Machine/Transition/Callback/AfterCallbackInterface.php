<?php

namespace Fsm\Machine\Transition\Callback;

use Fsm\Collection\Property\PropertyCollection;
use Fsm\Machine\StatefulInterface;
use Fsm\Machine\State\StateInterface;

interface AfterCallbackInterface
{
    /**
     * Handles callback after transition form state '$state' to state '$to'
     *
     * @param StatefulInterface $stateful
     * @param StateInterface $state
     * @param string $to
     * @param PropertyCollection|null $transitionProperties
     * @return mixed
     */
    public function __invoke(StatefulInterface $stateful, StateInterface $state, string $to, ?PropertyCollection $transitionProperties = null);
}
