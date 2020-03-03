<?php

namespace Fsm\Machine;

use Fsm\Machine\State\StateInterface;
use Fsm\Exception\StateMissingException;
use Fsm\Exception\TransitionMissingException;
use Fsm\Collection\Property\PropertyCollection;
use Fsm\Exception\ImpossibleTransitionException;

interface StateMachineInterface
{
    function getCurrentState(): StateInterface;

    /**
     * Checks if transition can be applied
     *
     * @param string $transitionName
     * @return bool
     * @throws TransitionMissingException
     */
    function can(string $transitionName): bool;

    /**
     * Applies the transition
     *
     * @param string $transitionName
     * @param PropertyCollection|null $properties
     * @return mixed
     * @throws TransitionMissingException
     * @throws ImpossibleTransitionException
     * @throws StateMissingException
     */
    function apply(string $transitionName, ?PropertyCollection $properties = null);
}
