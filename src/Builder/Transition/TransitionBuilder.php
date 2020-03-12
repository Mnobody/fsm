<?php

namespace Fsm\Builder\Transition;

use Fsm\Machine\Transition\Transition;
use Fsm\Machine\Transition\TransitionInterface;
use Fsm\Machine\Transition\Guard\GuardInterface;
use Fsm\Machine\Transition\Callback\CallbackInterface;

final class TransitionBuilder implements TransitionBuilderInterface
{
    private string $name;

    private string $from;

    private string $to;

    private ?GuardInterface $guard = null;

    private ?CallbackInterface $callback = null;

    public function setName(string $name): TransitionBuilderInterface
    {
        $this->name = $name;

        return $this;
    }

    public function setFrom(string $from): TransitionBuilderInterface
    {
        $this->from = $from;

        return $this;
    }

    public function setTo(string $to): TransitionBuilderInterface
    {
        $this->to = $to;

        return $this;
    }

    public function setGuard(GuardInterface $guard = null): TransitionBuilderInterface
    {
        $this->guard = $guard;

        return $this;
    }

    public function setCallback(CallbackInterface $callback = null): TransitionBuilderInterface
    {
        $this->callback = $callback;

        return $this;
    }

    public function build(): TransitionInterface
    {
        return new Transition($this->name, $this->from, $this->to, $this->guard, $this->callback);
    }
}