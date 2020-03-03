<?php

/**
 * States: Multiple "locked" states, one "unlocked" state
 * Transitions: Correct combinations move us from initial locked states to locked states closer to the unlocked state,
 * until we finally get to the unlocked state. Incorrect combinations land us back in the initial locked state.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Fsm\Facade;
use Fsm\Machine\State\State;
use Fsm\Machine\StatefulInterface;
use Fsm\Machine\State\StateInterface;
use Fsm\Collection\Property\PropertyCollection;
use Fsm\Machine\Transition\Callback\BeforeCallbackInterface;
use Fsm\Machine\Transition\Callback\CallbackResultShouldProceed;
use Fsm\Machine\Transition\Callback\CallbackResultStopProceeding;
use Fsm\Machine\Transition\Callback\BeforeCallbackResultInterface;

class Safe implements StatefulInterface
{
    private StateInterface $state;

    public function setState(StateInterface $state)
    {
        $this->state = $state;
    }

    public function hasState(): bool
    {
        return isset($this->state);
    }

    public function getState(): StateInterface
    {
        return $this->state;
    }

    public function getCorrectCombination(): string
    {
        return '34567898'; // safe opening combination
    }
}

class CombinationChecker implements BeforeCallbackInterface
{
    public function __invoke(StatefulInterface $stateful, StateInterface $state, string $to,
                             ?PropertyCollection $transitionProperties = null): BeforeCallbackResultInterface
    {
        $try = $transitionProperties->getProperty('combination');

        /** @var Safe $stateful */
        if ($stateful->getCorrectCombination() === $try) {
            // correct combination
            return new CallbackResultShouldProceed();
        }

        // incorrect combination
        return new CallbackResultStopProceeding();
    }
}

$safe = new Safe();

$machine = (new Facade)->machine(
    $safe,
    [
        ['name' => 'locked', 'type' => State::TYPE_INITIAL],
        ['name' => 'unlocked', 'type' => State::TYPE_FINAL],
    ],
    [
        ['name' => 'unlock', 'from' => 'locked', 'to' => 'unlocked', 'beforeCallback' => new CombinationChecker],
    ]
);

// usage

echo $machine->getCurrentState()->getName();

// return true, we can apply this transition
echo $machine->can('unlock');
$machine->apply('unlock', new PropertyCollection(['combination' => '45645654'])); // wrong combination
echo $machine->getCurrentState()->getName();

echo $machine->can('unlock');
$machine->apply('unlock', new PropertyCollection(['combination' => '34567898'])); // correct combination
echo $machine->getCurrentState()->getName();
