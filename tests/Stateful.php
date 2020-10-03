<?php

namespace Tests;

use Fsm\Machine\State\State;
use Fsm\Machine\Stateful\StatefulInterface;

class Stateful implements StatefulInterface
{
    private State $state;

    public function setState(State $state)
    {
        $this->state = $state;
    }

    public function hasState(): bool
    {
        return isset($this->state);
    }

    public function getState(): State
    {
        return $this->state;
    }
}
