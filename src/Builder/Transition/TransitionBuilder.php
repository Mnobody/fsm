<?php

namespace Fsm\Builder\Transition;

use Fsm\Machine\Transition\Transition;
use Fsm\Machine\Transition\TransitionInterface;
use Fsm\Machine\Transition\Callback\AfterCallbackInterface;
use Fsm\Machine\Transition\Callback\BeforeCallbackInterface;

final class TransitionBuilder implements TransitionBuilderInterface
{
    private string $name;

    private string $from;

    private string $to;

    private ?BeforeCallbackInterface $beforeCallback = null;

    private ?AfterCallbackInterface $afterCallback = null;

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

    public function setBeforeTransitionCallback(?BeforeCallbackInterface $callback = null): TransitionBuilderInterface
    {
        $this->beforeCallback = $callback;

        return $this;
    }

    public function setAfterTransitionCallback(?AfterCallbackInterface $callback = null): TransitionBuilderInterface
    {
        $this->afterCallback = $callback;

        return $this;
    }

    public function build(): TransitionInterface
    {
        return new Transition($this->name, $this->from, $this->to, $this->beforeCallback, $this->afterCallback);
    }
}