<?php

namespace Fsm\Machine;

use Fsm\Machine\State\StateInterface;

interface StatefulInterface
{
    function setState(StateInterface $state);

    function hasState(): bool;

    function getState(): StateInterface;
}