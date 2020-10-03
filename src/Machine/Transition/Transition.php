<?php

namespace Fsm\Machine\Transition;

use Fsm\Machine\Transition\Guard\GuardInterface;
use Fsm\Machine\Transition\Callback\CallbackInterface;

final class Transition
{
    private string $name;

    private string $from;

    private string $to;

    private ?GuardInterface $guard = null;

    private ?CallbackInterface $callback = null;

    public function __construct(string $name, string $from, string $to, GuardInterface $guard = null, CallbackInterface $callback = null)
    {
        $this->name = $name;
        $this->from = $from;
        $this->to = $to;
        $this->guard = $guard;
        $this->callback = $callback;
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

    public function hasGuard(): bool
    {
        return !is_null($this->guard);
    }

    public function getGuard(): ?GuardInterface
    {
        return $this->guard;
    }

    public function hasCallback(): bool
    {
        return !is_null($this->callback);
    }

    public function getCallback(): ?CallbackInterface
    {
        return $this->callback;
    }
}
