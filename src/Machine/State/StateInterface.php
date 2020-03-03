<?php

namespace Fsm\Machine\State;

use Fsm\Collection\Property\PropertyCollectionInterface;

interface StateInterface
{
    function getName(): string;

    function getType(): string;

    function isInitial(): bool;

    function isIntermediate(): bool;

    function isFinal(): bool;

    function hasProperties(): bool;

    function getProperties(): ?PropertyCollectionInterface;
}