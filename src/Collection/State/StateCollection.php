<?php

namespace Fsm\Collection\State;

use Fsm\Machine\State\State;
use Fsm\Collection\ImmutableCollection;
use Fsm\Exception\StateMissingException;

final class StateCollection extends ImmutableCollection
{
    private State $initial;

    /**
     * StateCollection constructor.
     * @param array $items
     * @throws StateMissingException
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);

        $this->init();
    }

    /**
     * @throws StateMissingException
     */
    private function init()
    {
        /** @var State $state */
        foreach ($this->items as $state) {
            if ($state->isInitial()) {
                $this->initial = $state;
            }
        }

        if (!isset($this->initial)) {
            throw new StateMissingException('Initial state is missing.');
        }
    }

    public function getInitial(): State
    {
        return $this->initial;
    }

    /**
     * @param string $name
     * @return State
     * @throws StateMissingException
     */
    public function getState(string $name): State
    {
        if (!isset($this->items[$name])) {
            throw new StateMissingException("The state: '$name' does not exists.");
        }

        return $this->items[$name];
    }
}
