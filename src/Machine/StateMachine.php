<?php

namespace Fsm\Machine;

use Fsm\Machine\State\StateInterface;
use Fsm\Exception\StateMissingException;
use Fsm\Exception\TransitionMissingException;
use Fsm\Machine\Transition\TransitionInterface;
use Fsm\Collection\Property\PropertyCollection;
use Fsm\Exception\ImpossibleTransitionException;
use Fsm\Collection\State\StateCollectionInterface;
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

    public function can(string $transitionName): bool
    {
        return $this->isTransitionStartsFromCurrentState($transitionName);
    }

    /**
     * @param string $transitionName
     * @return bool
     * @throws TransitionMissingException
     */
    private function isTransitionStartsFromCurrentState(string $transitionName): bool
    {
        $transition = $this->transitions->getTransition($transitionName);

        return ($transition->getFrom() === $this->getCurrentState()->getName());
    }

    public function apply(string $transitionName, ?PropertyCollection $properties = null)
    {
        if (!$this->can($transitionName)) {
            throw new ImpossibleTransitionException("The transition: '$transitionName' cannot be applied.");
        }

        $transition = $this->transitions->getTransition($transitionName);

        if (!$shouldProceed = $this->handleBeforeCallback($transition, $properties)) {
            return;
        }

        $this->makeTransition($transition);

        $this->handleAfterCallback($transition);
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

    private function handleBeforeCallback(TransitionInterface $transition, ?PropertyCollection $properties = null): bool
    {
        if (!$transition->hasBeforeTransitionCallback()) {
            return true;
        }

        $beforeCallback = $transition->getBeforeTransitionCallback();
        $result = $beforeCallback($this->stateful, $this->getCurrentState(), $transition->getTo(), $properties);

        return $result->shouldProceed();
    }

    private function handleAfterCallback(TransitionInterface $transition, ?PropertyCollection $properties = null)
    {
        if (!$transition->hasAfterTransitionCallback()) {
            return;
        }

        $afterCallback = $transition->getAfterTransitionCallback();
        $afterCallback($this->stateful, $this->getCurrentState(), $transition->getTo(), $properties);
    }
}