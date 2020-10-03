<?php

namespace Tests;

use Fsm\Facade;
use Fsm\Machine\State\State;
use PHPUnit\Framework\TestCase;
use Fsm\Machine\StateMachine;
use Fsm\Exception\TransitionMissingException;
use Fsm\Exception\ImpossibleTransitionException;

class TransitionTest extends TestCase
{
    private StateMachine $twoStepMachine;

    private StateMachine $threeStepMachine;

    protected function setUp(): void
    {
        $this->twoStepMachine = (new Facade)->machine(
            new Stateful,
            [
                ['name' => 'a', 'type' => State::TYPE_INITIAL],
                ['name' => 'b', 'type' => State::TYPE_FINAL],
            ],
            [['name' => 'a-to-b', 'from' => 'a', 'to' => 'b']]
        );

        $this->threeStepMachine = (new Facade)->machine(
            new Stateful,
            [
                ['name' => 'a', 'type' => State::TYPE_INITIAL],
                ['name' => 'b', 'type' => State::TYPE_INTERMEDIATE],
                ['name' => 'c', 'type' => State::TYPE_FINAL],
            ],
            [
                ['name' => 'a-to-b', 'from' => 'a', 'to' => 'b'],
                ['name' => 'b-to-c', 'from' => 'b', 'to' => 'c'],
            ]
        );
    }

    public function testTransitionMissingException()
    {
        $this->expectException(TransitionMissingException::class);
        $this->expectExceptionMessageMatches('/The transition: .* does not exists./');

        $this->twoStepMachine->can('non-existing-transition');
    }

    public function testSuccessScenarioTwoStep()
    {
        $this->assertTrue($this->twoStepMachine->can('a-to-b'));

        $this->assertEquals('a', $this->twoStepMachine->getCurrentState()->getName());

        $this->twoStepMachine->apply('a-to-b');

        $this->assertEquals('b', $this->twoStepMachine->getCurrentState()->getName());
    }

    public function testImpossibleTransitionException()
    {
        $this->expectException(ImpossibleTransitionException::class);
        $this->expectExceptionMessageMatches('/The transition: .* cannot be applied./');

        $this->threeStepMachine->apply('b-to-c');
    }

    public function testCanApplyTransition()
    {
        $this->assertTrue($this->threeStepMachine->can('a-to-b'));
        $this->assertFalse($this->threeStepMachine->can('b-to-c'));
    }
}
