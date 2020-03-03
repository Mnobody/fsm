<?php

namespace Fsm\Builder\State;

use Fsm\Machine\State\State;
use Fsm\Machine\State\StateInterface;
use Fsm\Collection\Property\PropertyCollection;

final class StateBuilder implements StateBuilderInterface
{
    private string $name;

    private ?PropertyCollection $properties = null;

    public function buildInitial(): StateInterface
    {
        return new State($this->name, State::TYPE_INITIAL, $this->properties);
    }

    public function buildIntermediate(): StateInterface
    {
        return new State($this->name, State::TYPE_INTERMEDIATE, $this->properties);
    }

    public function buildFinal(): StateInterface
    {
        return new State($this->name, State::TYPE_FINAL, $this->properties);
    }

    public function setName(string $name): StateBuilderInterface
    {
        $this->name = $name;

        return $this;
    }

    public function setProperties(?PropertyCollection $properties = null): StateBuilderInterface
    {
        $this->properties = $properties;

        return $this;
    }
}
