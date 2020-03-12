<?php

namespace Fsm\Machine;

use Fsm\Machine\State\StateInterface;
use Fsm\Exception\StateMissingException;
use Fsm\Exception\TransitionMissingException;
use Fsm\Exception\ImpossibleTransitionException;
use Fsm\Collection\Argument\ArgumentCollectionInterface;

interface StateMachineInterface
{
    function getCurrentState(): StateInterface;

    /**
     * Checks if transition can be applied
     *
     * @param string $transitionName
     * @param ArgumentCollectionInterface|null $arguments
     * @return bool
     * @throws TransitionMissingException
     */
    function can(string $transitionName, ArgumentCollectionInterface $arguments = null): bool;

    /**
     * Applies the transition
     *
     * @param string $transitionName
     * @param ArgumentCollectionInterface|null $arguments
     * @return mixed
     * @throws TransitionMissingException
     * @throws ImpossibleTransitionException
     * @throws StateMissingException
     */
    function apply(string $transitionName, ArgumentCollectionInterface $arguments = null);
}
