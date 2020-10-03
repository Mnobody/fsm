<?php

namespace Fsm;

use Fsm\Machine\State\State;
use Fsm\Exception\FsmException;
use Fsm\Machine\Stateful\StatefulInterface;
use Fsm\Builder\State\StateBuilder;
use Fsm\Builder\StateMachineBuilder;
use Fsm\Machine\StateMachine;
use Fsm\Builder\Transition\TransitionBuilder;
use Fsm\Collection\Property\PropertyCollection;
use Fsm\Machine\Transition\Transition;
use Fsm\Machine\Transition\Guard\GuardInterface;
use Fsm\Machine\Transition\Callback\CallbackInterface;

final class Facade
{
    public function state(string $type, string $name, PropertyCollection $properties = null): State
    {
        $builder = (new StateBuilder)
            ->setName($name)
            ->setProperties($properties);

        switch ($type) {
            case State::TYPE_INITIAL:
                return $builder->buildInitial();
            case State::TYPE_INTERMEDIATE:
                return $builder->buildIntermediate();
            case State::TYPE_FINAL:
                return $builder->buildFinal();
            default:
                throw new FsmException('Wrong state type provided.');
        }
    }

    public function transition(string $name, string $from, string $to, GuardInterface $guard = null, CallbackInterface $callback = null): Transition
    {
        return (new TransitionBuilder)
            ->setName($name)
            ->setFrom($from)
            ->setTo($to)
            ->setGuard($guard)
            ->setCallback($callback)
            ->build();
    }

    public function machine(StatefulInterface $stateful, array $states, array $transitions): StateMachine
    {
        $builder = (new StateMachineBuilder)->setStateful($stateful);

        foreach ($states as $state) {
            $properties = $state['properties'] ?? null;

            $builder->addState(
                $this->state($state['type'], $state['name'], $properties)
            );
        }

        foreach ($transitions as $transition) {
            $guard = $transition['guard'] ?? null;
            $callback = $transition['callback'] ?? null;

            $builder->addTransition(
                $this->transition($transition['name'], $transition['from'], $transition['to'], $guard, $callback)
            );
        }

        return $builder->build();
    }
}
