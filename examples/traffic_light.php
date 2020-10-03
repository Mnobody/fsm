<?php

/**
 * States: Red, Yellow, Green
 * Transitions: After a given time, Red will change to Green, Green to Yellow, and Yellow to Red
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Fsm\Facade;
use Fsm\Machine\State\State;
use Fsm\Machine\Stateful\StatefulInterface;

class Light implements StatefulInterface
{
    const STATE_RED = 'red';
    const STATE_YELLOW = 'yellow';
    const STATE_GREEN = 'green';

    const TRANSITION_RED_TO_YELLOW = 'red-to-yellow';
    const TRANSITION_YELLOW_TO_GREEN = 'yellow-to-green';
    const TRANSITION_GREEN_TO_RED = 'green-to-red';

    private State $state;

    public function setState(State $state)
    {
        $this->state = $state;
    }

    public function hasState(): bool
    {
        return isset($this->state);
    }

    public function getState(): State
    {
        return $this->state;
    }
}

$machine = (new Facade)->machine(
    new Light,
    [
        ['name' => Light::STATE_RED, 'type' => State::TYPE_INITIAL],
        ['name' => Light::STATE_YELLOW, 'type' => State::TYPE_INTERMEDIATE],
        ['name' => Light::STATE_GREEN, 'type' => State::TYPE_FINAL],
    ],
    [
        ['name' => Light::TRANSITION_RED_TO_YELLOW, 'from' => Light::STATE_RED, 'to' => Light::STATE_YELLOW],
        ['name' => Light::TRANSITION_YELLOW_TO_GREEN, 'from' => Light::STATE_YELLOW, 'to' => Light::STATE_GREEN],
        ['name' => Light::TRANSITION_GREEN_TO_RED, 'from' => Light::STATE_GREEN, 'to' => Light::STATE_RED],
    ]
);

// switch light 10 times
for ($i = 0; $i < 10; $i++) {
    sleep(1); // wait until next light switch

    switch ($machine->getCurrentState()->getName()) {
        case Light::STATE_RED:
            $machine->apply(Light::TRANSITION_RED_TO_YELLOW);
            break;
        case Light::STATE_YELLOW:
            $machine->apply(Light::TRANSITION_YELLOW_TO_GREEN);
            break;
        case Light::STATE_GREEN:
            $machine->apply(Light::TRANSITION_GREEN_TO_RED);
            break;
    }
}
