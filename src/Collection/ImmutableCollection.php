<?php

namespace Fsm\Collection;

class ImmutableCollection implements ImmutableCollectionInterface
{
    protected array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }
}
