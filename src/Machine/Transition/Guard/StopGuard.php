<?php

namespace Fsm\Machine\Transition\Guard;

use Fsm\Machine\StatefulInterface;
use Fsm\Machine\State\StateInterface;
use Fsm\Collection\Argument\ArgumentCollectionInterface;

class StopGuard implements GuardInterface
{
    public function pass(StatefulInterface $stateful, StateInterface $state, string $to, ArgumentCollectionInterface $arguments = null): bool
    {
        return false;
    }
}
