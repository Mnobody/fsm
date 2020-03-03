<?php

namespace Fsm\Machine\Transition\Callback;

class CallbackResultStopProceeding implements BeforeCallbackResultInterface
{
    public function shouldProceed(): bool
    {
        return false;
    }
}
