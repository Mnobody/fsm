<?php

namespace Fsm\Builder\Transition;

use Fsm\Machine\Transition\TransitionInterface;
use Fsm\Machine\Transition\Guard\GuardInterface;
use Fsm\Machine\Transition\Callback\CallbackInterface;

interface TransitionBuilderInterface
{
    function build(): TransitionInterface;

    function setName(string $name): TransitionBuilderInterface;

    function setFrom(string $from): TransitionBuilderInterface;

    function setTo(string $to): TransitionBuilderInterface;

    function setGuard(GuardInterface $callback = null): TransitionBuilderInterface;

    function setCallback(CallbackInterface $callback = null): TransitionBuilderInterface;
}
