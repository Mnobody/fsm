<?php

namespace Tests;

use Fsm\Facade;
use Fsm\Machine\State\State;
use Fsm\Machine\StatefulInterface;
use PHPUnit\Framework\TestCase;
use Fsm\Machine\State\StateInterface;
use Fsm\Machine\StateMachineInterface;
use Fsm\Collection\Property\PropertyCollection;
use Fsm\Machine\Transition\Callback\AfterCallbackInterface;
use Fsm\Machine\Transition\Callback\BeforeCallbackInterface;
use Fsm\Machine\Transition\Callback\CallbackResultShouldProceed;
use Fsm\Machine\Transition\Callback\CallbackResultStopProceeding;
use Fsm\Machine\Transition\Callback\BeforeCallbackResultInterface;

class CallbackTest extends TestCase
{
    private StateMachineInterface $threeStepMachine;

    protected function setUp(): void
    {
        $this->threeStepMachine = (new Facade())->machine(
            new Stateful,
            [
                ['name' => 'a', 'type' => State::TYPE_INITIAL, 'properties' => new PropertyCollection(['key' => 'value'])],
                ['name' => 'b', 'type' => State::TYPE_INTERMEDIATE],
                ['name' => 'c', 'type' => State::TYPE_FINAL],
            ],
            [
                ['name' => 'a-to-b', 'from' => 'a', 'to' => 'b', 'beforeCallback' => new BeforeCallbackProceed],
                ['name' => 'b-to-c', 'from' => 'b', 'to' => 'c', 'beforeCallback' => new BeforeCallbackStopProceeding],
            ]
        );
    }

    public function testMakeFirstTransitionAndCancelSecond()
    {
        // check state
        $this->assertEquals('a', $this->threeStepMachine->getCurrentState()->getName());

        // first transition
        $this->assertTrue($this->threeStepMachine->can('a-to-b'));
        $this->threeStepMachine->apply('a-to-b');
        $this->assertEquals('b', $this->threeStepMachine->getCurrentState()->getName());

        // second transition doesn't pass
        $this->assertTrue($this->threeStepMachine->can('b-to-c'));
        $this->threeStepMachine->apply('b-to-c');
        $this->assertEquals('b', $this->threeStepMachine->getCurrentState()->getName());
    }

    public function testAfterCallbackPerformed()
    {
        $machine = (new Facade())->machine(
            new Stateful,
            [
                ['name' => 'a', 'type' => State::TYPE_INITIAL],
                ['name' => 'b', 'type' => State::TYPE_FINAL],
            ],
            [['name' => 'a-to-b', 'from' => 'a', 'to' => 'b', 'afterCallback' => new AfterCallbackThrowsException]]
        );

        $this->expectException(AfterCallbackException::class);
        $this->expectExceptionMessage('AfterCallback exception.');

        $machine->apply('a-to-b');
    }
}

class BeforeCallbackProceed implements BeforeCallbackInterface
{
    public function __invoke(StatefulInterface $stateful, StateInterface $state, string $to,
                             ?PropertyCollection $transitionProperties = null): BeforeCallbackResultInterface
    {
        return new CallbackResultShouldProceed();
    }
}

class BeforeCallbackStopProceeding implements BeforeCallbackInterface
{
    public function __invoke(StatefulInterface $stateful, StateInterface $state, string $to,
                             ?PropertyCollection $transitionProperties = null): BeforeCallbackResultInterface
    {
        return new CallbackResultStopProceeding();
    }
}

class AfterCallbackException extends \Exception {}

class AfterCallbackThrowsException implements AfterCallbackInterface
{
    public function __invoke(StatefulInterface $stateful, StateInterface $state, string $to,
                             ?PropertyCollection $transitionProperties = null)
    {
        throw new AfterCallbackException('AfterCallback exception.');
    }
}
