<?php

namespace Tests;

use Fsm\Facade;
use Fsm\Machine\State\State;
use PHPUnit\Framework\TestCase;
use Fsm\Machine\StateMachine;
use Fsm\Collection\Property\PropertyCollection;

class GuardTest extends TestCase
{
    private StateMachine $threeStepMachine;

    protected function setUp(): void
    {
        $this->threeStepMachine = (new Facade)->machine(
            new Stateful,
            [
                ['name' => 'a', 'type' => State::TYPE_INITIAL, 'properties' => new PropertyCollection(['key' => 'value'])],
                ['name' => 'b', 'type' => State::TYPE_INTERMEDIATE],
                ['name' => 'c', 'type' => State::TYPE_FINAL],
            ],
            [
                ['name' => 'a-to-b', 'from' => 'a', 'to' => 'b', 'guard' => new PassGuard],
                ['name' => 'b-to-c', 'from' => 'b', 'to' => 'c', 'guard' => new StopGuard],
            ]
        );
    }

    public function testMakeFirstTransitionAndCancelSecond()
    {
        // first transition passes
        $this->assertEquals('a', $this->threeStepMachine->getCurrentState()->getName());
        $this->assertTrue($this->threeStepMachine->can('a-to-b'));

        // second transition doesn't pass
        $this->assertFalse($this->threeStepMachine->can('b-to-c'));

        // second transition doesn't pass
        $this->threeStepMachine->apply('a-to-b');
        $this->assertEquals('b', $this->threeStepMachine->getCurrentState()->getName());
        $this->assertFalse($this->threeStepMachine->can('b-to-c'));
    }
}
