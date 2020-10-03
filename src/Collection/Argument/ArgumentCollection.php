<?php

namespace Fsm\Collection\Argument;

use Fsm\Collection\ImmutableCollection;
use Fsm\Exception\ArgumentMissingException;

final class ArgumentCollection extends ImmutableCollection
{
    public function getArgument(string $argument)
    {
        if (!$this->hasArgument($argument)) {
            throw new ArgumentMissingException("The argument: '$argument' does not exists.");
        }

        return $this->items[$argument];
    }

    public function hasArgument(string $argument): bool
    {
        return isset($this->items[$argument]);
    }
}
