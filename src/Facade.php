<?php

namespace Fsm;

use Fsm\Machine\State\State;
use Fsm\Exception\FsmException;
use Fsm\Machine\StatefulInterface;
use Fsm\Builder\State\StateBuilder;
use Fsm\Builder\StateMachineBuilder;
use Fsm\Machine\State\StateInterface;
use Fsm\Machine\StateMachineInterface;
use Fsm\Builder\Transition\TransitionBuilder;
use Fsm\Collection\Property\PropertyCollection;
use Fsm\Machine\Transition\TransitionInterface;
use Fsm\Machine\Transition\Callback\AfterCallbackInterface;
use Fsm\Machine\Transition\Callback\BeforeCallbackInterface;

final class Facade
{
    public function state(string $type, string $name, ?PropertyCollection $properties = null): StateInterface
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

    public function transition(string $name, string $from, string $to,
                                   ?BeforeCallbackInterface $beforeCallback = null,
                                   ?AfterCallbackInterface $afterCallback = null): TransitionInterface
    {
        return (new TransitionBuilder())
            ->setName($name)
            ->setFrom($from)
            ->setTo($to)
            ->setBeforeTransitionCallback($beforeCallback)
            ->setAfterTransitionCallback($afterCallback)
            ->build();
    }

    public function machine(StatefulInterface $stateful, array $states, array $transitions): StateMachineInterface
    {
        $builder = (new StateMachineBuilder())->setStateful($stateful);

        foreach ($states as $state) {
            $properties = $state['properties'] ?? null;

            $builder->addState(
                $this->state($state['type'], $state['name'], $properties)
            );
        }

        foreach ($transitions as $transition) {
            $beforeCallback = $transition['beforeCallback'] ?? null;
            $afterCallback = $transition['afterCallback'] ?? null;

            $builder->addTransition(
                $this->transition($transition['name'], $transition['from'], $transition['to'], $beforeCallback, $afterCallback)
            );
        }

        return $builder->build();
    }
}
