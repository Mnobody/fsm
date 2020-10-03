<?php

namespace Fsm\Machine;

use Fsm\Machine\State\State;
use Fsm\Exception\StateMissingException;
use Fsm\Machine\Stateful\StatefulInterface;
use Fsm\Machine\Transition\Transition;
use Fsm\Exception\ImpossibleTransitionException;
use Fsm\Collection\State\StateCollection;
use Fsm\Collection\Argument\ArgumentCollection;
use Fsm\Collection\Transition\TransitionCollection;

final class StateMachine
{
    private StatefulInterface $stateful;

    private StateCollection $states;

    private TransitionCollection $transitions;

    public function __construct(StatefulInterface $stateful, StateCollection $states, TransitionCollection $transitions)
    {
        $this->stateful = $stateful;
        $this->states = $states;
        $this->transitions = $transitions;
    }

    public function getCurrentState(): State
    {
        return $this->stateful->hasState() ? $this->stateful->getState() : $this->states->getInitial();
    }

    public function can(string $transitionName, ArgumentCollection $arguments = null): bool
    {
        $transition = $this->transitions->getTransition($transitionName);

        return (
            $this->isTransitionStartsFromCurrentState($transition)
            &&
            $this->handleGuard($transition, $arguments)
        );
    }

    private function isTransitionStartsFromCurrentState(Transition $transition): bool
    {
        return ($transition->getFrom() === $this->getCurrentState()->getName());
    }

    private function handleGuard(Transition $transition, ArgumentCollection $arguments = null): bool
    {
        if (!$transition->hasGuard()) {
            return true;
        }

        $guard = $transition->getGuard();
        return $guard->pass($this->stateful, $this->getCurrentState(), $transition->getTo(), $arguments);
    }

    public function apply(string $transitionName, ArgumentCollection $arguments = null)
    {
        if (!$this->can($transitionName, $arguments)) {
            throw new ImpossibleTransitionException("The transition: '$transitionName' cannot be applied.");
        }

        $transition = $this->transitions->getTransition($transitionName);

        $this->makeTransition($transition);

        $this->handleCallback($transition, $arguments);
    }

    /**
     * @param Transition $transition
     * @throws StateMissingException
     */
    private function makeTransition(Transition $transition)
    {
        $state = $this->states->getState($transition->getTo());
        $this->stateful->setState($state);
    }

    private function handleCallback(Transition $transition, ArgumentCollection $arguments = null)
    {
        if (!$transition->hasCallback()) {
            return;
        }

        $callback = $transition->getCallback();
        $callback->handle($this->stateful, $this->getCurrentState(), $transition->getTo(), $arguments);
    }
}
