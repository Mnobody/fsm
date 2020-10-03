<?php

namespace Tests;

use Fsm\Facade;
use Fsm\Machine\State\State;
use PHPUnit\Framework\TestCase;
use Fsm\Machine\StateMachine;
use Fsm\Exception\StateMissingException;
use Fsm\Exception\TransitionMissingException;
use Fsm\Collection\Property\PropertyCollection;
use Fsm\Machine\Transition\Guard\GuardInterface;
use Fsm\Machine\Transition\Callback\CallbackInterface;

class BuilderTest extends TestCase
{
    public function testInitializationWithRequiredParams()
    {
        $machine = (new Facade)->machine(
            new Stateful,
            [
                ['name' => 'a', 'type' => State::TYPE_INITIAL]
            ],
            [['name' => 'a-to-b', 'from' => 'a', 'to' => 'b']]
        );

        $this->assertInstanceOf(StateMachine::class, $machine);
    }

    public function testInitializationWithOptionalParamsAsNulls()
    {
        $machine = (new Facade)->machine(
            new Stateful,
            [
                ['name' => 'a', 'type' => State::TYPE_INITIAL, 'properties' => null],
                ['name' => 'b', 'type' => State::TYPE_INTERMEDIATE, 'properties' => null],
                ['name' => 'c', 'type' => State::TYPE_FINAL, 'properties' => null],
            ],
            [
                ['name' => 'a-to-b', 'from' => 'a', 'to' => 'b', 'guard' => null, 'callback' => null],
                ['name' => 'b-to-c', 'from' => 'b', 'to' => 'c', 'guard' => null, 'callback' => null],
            ]
        );

        $this->assertInstanceOf(StateMachine::class, $machine);
    }

    public function testInitializationWithAllParams()
    {
        $guard = $this->getMockBuilder(GuardInterface::class)
            ->setMockClassName('BeforeCallback')
            ->getMock();

        $callback = $this->getMockBuilder(CallbackInterface::class)
            ->setMockClassName('AfterCallback')
            ->getMock();

        $machine = (new Facade)->machine(
            new Stateful,
            [
                ['name' => 'a', 'type' => State::TYPE_INITIAL, 'properties' => new PropertyCollection],
                ['name' => 'b', 'type' => State::TYPE_INTERMEDIATE, 'properties' => new PropertyCollection(['testKey' => 'testValue'])],
                ['name' => 'c', 'type' => State::TYPE_FINAL, 'properties' => new PropertyCollection(['testKey2' => new \stdClass()])],
            ],
            [
                ['name' => 'a-to-b', 'from' => 'a', 'to' => 'b', 'guard' => $guard, 'callback' => $callback],
                ['name' => 'b-to-c', 'from' => 'b', 'to' => 'c', 'guard' => $guard, 'callback' => $callback],
            ]
        );

        $this->assertInstanceOf(StateMachine::class, $machine);
    }

    public function testInitialStateMissingException()
    {
        $this->expectException(StateMissingException::class);
        $this->expectExceptionMessage('Initial state is missing.');

        (new Facade)->machine(new Stateful, [['name' => 'b', 'type' => State::TYPE_FINAL]], [['name' => 'a-to-b', 'from' => 'a', 'to' => 'b']]);
    }

    public function testTransitionMissingException()
    {
        $this->expectException(TransitionMissingException::class);
        $this->expectExceptionMessage('Transitions list cannot be empty.');

        (new Facade)->machine(
            new Stateful,
            [['name' => 'a', 'type' => State::TYPE_INITIAL]],
            [] // empty transition array
        );
    }
}
