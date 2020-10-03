<?php

namespace Fsm\Builder\State;

use Fsm\Machine\State\State;
use Fsm\Collection\Property\PropertyCollection;

final class StateBuilder
{
    private string $name;

    private ?PropertyCollection $properties = null;

    public function buildInitial(): State
    {
        return new State($this->name, State::TYPE_INITIAL, $this->properties);
    }

    public function buildIntermediate(): State
    {
        return new State($this->name, State::TYPE_INTERMEDIATE, $this->properties);
    }

    public function buildFinal(): State
    {
        return new State($this->name, State::TYPE_FINAL, $this->properties);
    }

    public function setName(string $name): StateBuilder
    {
        $this->name = $name;

        return $this;
    }

    public function setProperties(PropertyCollection $properties = null): StateBuilder
    {
        $this->properties = $properties;

        return $this;
    }
}
