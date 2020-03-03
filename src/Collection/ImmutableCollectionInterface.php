<?php

namespace Fsm\Collection;

interface ImmutableCollectionInterface
{
    function getItems(): array;

    function isEmpty(): bool;
}
