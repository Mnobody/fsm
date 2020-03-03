<?php

namespace Fsm\Builder;

use Fsm\Machine\StateMachine;
use Fsm\Machine\StatefulInterface;
use Fsm\Machine\State\StateInterface;
use Fsm\Machine\StateMachineInterface;
use Fsm\Exception\StateMissingException;
use Fsm\Collection\State\StateCollection;
use Fsm\Machine\Transition\TransitionInterface;
use Fsm\Collection\Transition\TransitionCollection;

final class StateMachineBuilder implements StateMachineBuilderInterface
{
    private StatefulInterface $stateful;

    private array $states = [];

    private array $transitions = [];

    /**
     * @return StateMachineInterface
     * @throws StateMissingException
     */
    public function build(): StateMachineInterface
    {
        $states = new StateCollection($this->states);
        $transitions = new TransitionCollection($this->transitions);

        return new StateMachine($this->stateful, $states, $transitions);
    }

    public function setStateful(StatefulInterface $stateful): StateMachineBuilderInterface
    {
        $this->stateful = $stateful;

        return $this;
    }

    public function addState(StateInterface $state): StateMachineBuilderInterface
    {
        $this->states[$state->getName()] = $state;

        return $this;
    }

    public function addTransition(TransitionInterface $transition): StateMachineBuilderInterface
    {
        $this->transitions[$transition->getName()] = $transition;

        return $this;
    }
}
