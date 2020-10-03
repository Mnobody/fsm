<?php

namespace Fsm\Collection\Transition;

use Fsm\Collection\ImmutableCollection;
use Fsm\Exception\TransitionMissingException;
use Fsm\Machine\Transition\Transition;

final class TransitionCollection extends ImmutableCollection
{
    /**
     * TransitionCollection constructor.
     * @param array $items
     * @throws TransitionMissingException
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);

        $this->init();
    }

    /**
     * @throws TransitionMissingException
     */
    private function init()
    {
        if ($this->isEmpty()) {
            throw new TransitionMissingException('Transitions list cannot be empty.');
        }
    }

    /**
     * @param string $name
     * @return Transition
     * @throws TransitionMissingException
     */
    public function getTransition(string $name): Transition
    {
        if (!isset($this->items[$name])) {
            throw new TransitionMissingException("The transition: '$name' does not exists.");
        }

        return $this->items[$name];
    }
}
