<?php

namespace Fsm\Builder\Transition;

use Fsm\Machine\Transition\Transition;
use Fsm\Machine\Transition\Guard\GuardInterface;
use Fsm\Machine\Transition\Callback\CallbackInterface;

final class TransitionBuilder
{
    private string $name;

    private string $from;

    private string $to;

    private ?GuardInterface $guard = null;

    private ?CallbackInterface $callback = null;

    public function setName(string $name): TransitionBuilder
    {
        $this->name = $name;

        return $this;
    }

    public function setFrom(string $from): TransitionBuilder
    {
        $this->from = $from;

        return $this;
    }

    public function setTo(string $to): TransitionBuilder
    {
        $this->to = $to;

        return $this;
    }

    public function setGuard(GuardInterface $guard = null): TransitionBuilder
    {
        $this->guard = $guard;

        return $this;
    }

    public function setCallback(CallbackInterface $callback = null): TransitionBuilder
    {
        $this->callback = $callback;

        return $this;
    }

    public function build(): Transition
    {
        return new Transition($this->name, $this->from, $this->to, $this->guard, $this->callback);
    }
}