<?php

namespace Fsm\Machine\Transition\Callback;

class CallbackResultShouldProceed implements BeforeCallbackResultInterface
{
    public function shouldProceed(): bool
    {
        return true;
    }
}
