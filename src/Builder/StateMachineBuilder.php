<?php

namespace Fsm\Builder;

use Fsm\Machine\StateMachine;
use Fsm\Machine\Stateful\StatefulInterface;
use Fsm\Machine\State\State;
use Fsm\Exception\StateMissingException;
use Fsm\Collection\State\StateCollection;
use Fsm\Exception\TransitionMissingException;
use Fsm\Machine\Transition\Transition;
use Fsm\Collection\Transition\TransitionCollection;

final class StateMachineBuilder
{
    private StatefulInterface $stateful;

    private array $states = [];

    private array $transitions = [];

    /**
     * @return StateMachine
     * @throws StateMissingException
     * @throws TransitionMissingException
     */
    public function build(): StateMachine
    {
        $states = new StateCollection($this->states);
        $transitions = new TransitionCollection($this->transitions);

        return new StateMachine($this->stateful, $states, $transitions);
    }

    public function setStateful(StatefulInterface $stateful): StateMachineBuilder
    {
        $this->stateful = $stateful;

        return $this;
    }

    public function addState(State $state): StateMachineBuilder
    {
        $this->states[$state->getName()] = $state;

        return $this;
    }

    public function addTransition(Transition $transition): StateMachineBuilder
    {
        $this->transitions[$transition->getName()] = $transition;

        return $this;
    }
}
