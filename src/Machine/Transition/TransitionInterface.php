<?php

namespace Fsm\Machine\Transition;

use Fsm\Machine\Transition\Callback\AfterCallbackInterface;
use Fsm\Machine\Transition\Callback\BeforeCallbackInterface;

interface TransitionInterface
{
    function getName(): string;

    function getFrom(): string;

    function getTo(): string;

    function hasBeforeTransitionCallback(): bool;

    function getBeforeTransitionCallback(): ?BeforeCallbackInterface;

    function hasAfterTransitionCallback(): bool;

    function getAfterTransitionCallback(): ?AfterCallbackInterface;

}