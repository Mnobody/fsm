<?php

namespace Fsm\Machine\Transition;

use Fsm\Machine\Transition\Guard\GuardInterface;
use Fsm\Machine\Transition\Callback\CallbackInterface;

interface TransitionInterface
{
    function getName(): string;

    function getFrom(): string;

    function getTo(): string;

    function hasGuard(): bool;

    function getGuard(): ?GuardInterface;

    function hasCallback(): bool;

    function getCallback(): ?CallbackInterface;
}
