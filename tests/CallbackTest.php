<?php

namespace Tests;

use Fsm\Facade;
use Fsm\Machine\State\State;
use PHPUnit\Framework\TestCase;
use Fsm\Machine\StatefulInterface;
use Fsm\Machine\State\StateInterface;
use Fsm\Machine\Transition\Callback\CallbackInterface;
use Fsm\Collection\Argument\ArgumentCollectionInterface;

class CallbackTest extends TestCase
{
    public function testCallbackPerformed()
    {
        $machine = (new Facade)->machine(
            new Stateful,
            [
                ['name' => 'a', 'type' => State::TYPE_INITIAL],
                ['name' => 'b', 'type' => State::TYPE_FINAL],
            ],
            [['name' => 'a-to-b', 'from' => 'a', 'to' => 'b', 'callback' => new CallbackThrowsException]]
        );

        $this->expectException(AfterCallbackException::class);
        $this->expectExceptionMessage('AfterCallback exception.');

        $machine->apply('a-to-b');
    }
}

class AfterCallbackException extends \Exception {}

class CallbackThrowsException implements CallbackInterface
{
    public function handle(StatefulInterface $stateful, StateInterface $state, string $to, ArgumentCollectionInterface $arguments = null)
    {
        throw new AfterCallbackException('AfterCallback exception.');
    }
}
