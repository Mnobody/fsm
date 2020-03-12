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
use Fsm\Collection\Argument\ArgumentCollection;
use Fsm\Machine\Transition\Guard\GuardInterface;
use Fsm\Collection\Argument\ArgumentCollectionInterface;

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
        return '34567898'; // correct combination
    }
}

class CombinationChecker implements GuardInterface
{
    public function pass(StatefulInterface $stateful, StateInterface $state, string $to, ArgumentCollectionInterface $arguments = null): bool
    {
        $attempt = $arguments->getArgument('combination');

        /** @var Safe $stateful */
        if ($stateful->getCorrectCombination() === $attempt) {
            // correct combination
            return true;
        }

        return false;
    }
}

$machine = (new Facade)->machine(
    new Safe,
    [
        ['name' => 'locked', 'type' => State::TYPE_INITIAL],
        ['name' => 'unlocked', 'type' => State::TYPE_FINAL],
    ],
    [
        ['name' => 'unlock', 'from' => 'locked', 'to' => 'unlocked', 'guard' => new CombinationChecker],
    ]
);

echo $machine->getCurrentState()->getName();

$wrong = new ArgumentCollection(['combination' => '45645654']); // wrong combination
echo $machine->can('unlock', $wrong);
echo $machine->getCurrentState()->getName();

$correct = new ArgumentCollection(['combination' => '34567898']); // correct combination
echo $machine->can('unlock', $correct);
$machine->apply('unlock', $correct);
echo $machine->getCurrentState()->getName();
