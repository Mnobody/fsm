<?php

namespace Fsm\Machine\Transition\Callback;

use Fsm\Collection\Property\PropertyCollection;
use Fsm\Machine\StatefulInterface;
use Fsm\Machine\State\StateInterface;

interface BeforeCallbackInterface
{
    /**
     * Handles callback before transition form state '$state' to state '$to'
     *
     * @param StatefulInterface $stateful
     * @param StateInterface $state
     * @param string $to
     * @param PropertyCollection|null $transitionProperties
     * @return BeforeCallbackResultInterface
     */
    public function __invoke(StatefulInterface $stateful, StateInterface $state, string $to,
                             ?PropertyCollection $transitionProperties = null): BeforeCallbackResultInterface;
}
