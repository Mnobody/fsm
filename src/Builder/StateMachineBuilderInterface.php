<?php

namespace Fsm\Builder;

use Fsm\Machine\StatefulInterface;
use Fsm\Machine\State\StateInterface;
use Fsm\Machine\StateMachineInterface;
use Fsm\Machine\Transition\TransitionInterface;

interface StateMachineBuilderInterface
{
    function build(): StateMachineInterface;

    function setStateful(StatefulInterface $stateful): StateMachineBuilderInterface;

    function addState(StateInterface $state): StateMachineBuilderInterface;

    function addTransition(TransitionInterface $transition): StateMachineBuilderInterface;
}