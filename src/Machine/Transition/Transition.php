<?php

namespace Fsm\Machine\Transition;

use Fsm\Machine\Transition\Callback\AfterCallbackInterface;
use Fsm\Machine\Transition\Callback\BeforeCallbackInterface;

final class Transition implements TransitionInterface
{
    private string $name;

    private string $from;

    private string $to;

    private ?BeforeCallbackInterface $beforeCallback = null;

    private ?AfterCallbackInterface $afterCallback = null;

    public function __construct(string $name, string $from, string $to,
                                ?BeforeCallbackInterface $beforeCallback = null, ?AfterCallbackInterface $afterCallback = null)
    {
        $this->name = $name;
        $this->from = $from;
        $this->to = $to;
        $this->beforeCallback = $beforeCallback;
        $this->afterCallback = $afterCallback;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function hasBeforeTransitionCallback(): bool
    {
        return !is_null($this->beforeCallback);
    }

    public function getBeforeTransitionCallback(): ?BeforeCallbackInterface
    {
        return $this->beforeCallback;
    }

    public function hasAfterTransitionCallback(): bool
    {
        return !is_null($this->afterCallback);
    }

    public function getAfterTransitionCallback(): ?AfterCallbackInterface
    {
        return $this->afterCallback;
    }
}
