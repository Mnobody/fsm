<?php

namespace Tests;

use Fsm\Machine\State\State;
use Fsm\Machine\Stateful\StatefulInterface;
use Fsm\Collection\Argument\ArgumentCollection;
use Fsm\Machine\Transition\Guard\GuardInterface;

final class PassGuard implements GuardInterface
{
    public function pass(StatefulInterface $stateful, State $from, State $to, ArgumentCollection $arguments = null): bool
    {
        return true;
    }
}
