<?php

namespace Tests;

use Fsm\Machine\State\StateInterface;
use Fsm\Machine\StatefulInterface;

class Stateful implements StatefulInterface
{
    private StateInterface $state;

    public function setState(StateInterface $state)
    {
        $this->state = $state;
    }

    public function hasState(): bool
    {
        return isset($this->state);
    }

    public function getState(): StateInterface
    {
        return $this->state;
    }
}
