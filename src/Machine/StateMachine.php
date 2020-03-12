<?php

namespace Fsm\Machine;

use Fsm\Machine\State\StateInterface;
use Fsm\Exception\StateMissingException;
use Fsm\Machine\Transition\TransitionInterface;
use Fsm\Exception\ImpossibleTransitionException;
use Fsm\Collection\State\StateCollectionInterface;
use Fsm\Collection\Argument\ArgumentCollectionInterface;
use Fsm\Collection\Transition\TransitionCollectionInterface;

final class StateMachine implements StateMachineInterface
{
    private StatefulInterface $stateful;

    private StateCollectionInterface $states;

    private TransitionCollectionInterface $transitions;

    public function __construct(StatefulInterface $stateful, StateCollectionInterface $states, TransitionCollectionInterface $transitions)
    {
        $this->stateful = $stateful;
        $this->states = $states;
        $this->transitions = $transitions;
    }

    public function getCurrentState(): StateInterface
    {
        return $this->stateful->hasState() ? $this->stateful->getState() : $this->states->getInitial();
    }

    public function can(string $transitionName, ArgumentCollectionInterface $arguments = null): bool
    {
        $transition = $this->transitions->getTransition($transitionName);

        return (
            $this->isTransitionStartsFromCurrentState($transition)
            &&
            $this->handleGuard($transition, $arguments)
        );
    }

    private function isTransitionStartsFromCurrentState(TransitionInterface $transition): bool
    {
        return ($transition->getFrom() === $this->getCurrentState()->getName());
    }

    private function handleGuard(TransitionInterface $transition, ArgumentCollectionInterface $arguments = null): bool
    {
        if (!$transition->hasGuard()) {
            return true;
        }

        $guard = $transition->getGuard();
        return $guard->pass($this->stateful, $this->getCurrentState(), $transition->getTo(), $arguments);
    }

    public function apply(string $transitionName, ArgumentCollectionInterface $arguments = null)
    {
        if (!$this->can($transitionName, $arguments)) {
            throw new ImpossibleTransitionException("The transition: '$transitionName' cannot be applied.");
        }

        $transition = $this->transitions->getTransition($transitionName);

        $this->makeTransition($transition);

        $this->handleCallback($transition, $arguments);
    }

    /**
     * @param TransitionInterface $transition
     * @throws StateMissingException
     */
    private function makeTransition(TransitionInterface $transition)
    {
        $state = $this->states->getState($transition->getTo());
        $this->stateful->setState($state);
    }

    private function handleCallback(TransitionInterface $transition, ArgumentCollectionInterface $arguments = null)
    {
        if (!$transition->hasCallback()) {
            return;
        }

        $callback = $transition->getCallback();
        $callback->handle($this->stateful, $this->getCurrentState(), $transition->getTo(), $arguments);
    }
}
