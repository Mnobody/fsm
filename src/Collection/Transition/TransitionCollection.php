<?php

namespace Fsm\Collection\Transition;

use Fsm\Collection\ImmutableCollection;
use Fsm\Exception\TransitionMissingException;
use Fsm\Machine\Transition\TransitionInterface;

final class TransitionCollection extends ImmutableCollection implements TransitionCollectionInterface
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
     * @return TransitionInterface
     * @throws TransitionMissingException
     */
    public function getTransition(string $name): TransitionInterface
    {
        if (!isset($this->items[$name])) {
            throw new TransitionMissingException("The transition: '$name' does not exists.");
        }

        return $this->items[$name];
    }
}
