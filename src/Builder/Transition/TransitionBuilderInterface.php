<?php

namespace Fsm\Builder\Transition;

use Fsm\Machine\Transition\TransitionInterface;
use Fsm\Machine\Transition\Callback\AfterCallbackInterface;
use Fsm\Machine\Transition\Callback\BeforeCallbackInterface;

interface TransitionBuilderInterface
{
    function build(): TransitionInterface;

    function setName(string $name): TransitionBuilderInterface;

    function setFrom(string $from): TransitionBuilderInterface;

    function setTo(string $to): TransitionBuilderInterface;

    function setBeforeTransitionCallback(?BeforeCallbackInterface $callback = null): TransitionBuilderInterface;

    function setAfterTransitionCallback(?AfterCallbackInterface $callback = null): TransitionBuilderInterface;
}