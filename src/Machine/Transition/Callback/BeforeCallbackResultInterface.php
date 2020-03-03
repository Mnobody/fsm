<?php

namespace Fsm\Machine\Transition\Callback;

interface BeforeCallbackResultInterface
{
    public function shouldProceed(): bool;
}
