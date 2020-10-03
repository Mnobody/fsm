<?php

namespace Fsm\Machine\Stateful;

use Fsm\Machine\State\State;

interface StatefulInterface
{
    function setState(State $state);

    function hasState(): bool;

    function getState(): State;
}