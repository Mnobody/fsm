<?php

namespace Fsm\Builder\State;

use Fsm\Machine\State\StateInterface;
use Fsm\Collection\Property\PropertyCollection;

interface StateBuilderInterface
{
    function buildInitial(): StateInterface;

    function buildIntermediate(): StateInterface;

    function buildFinal(): StateInterface;

    function setName(string $name): StateBuilderInterface;

    function setProperties(?PropertyCollection $properties = null): StateBuilderInterface;
}