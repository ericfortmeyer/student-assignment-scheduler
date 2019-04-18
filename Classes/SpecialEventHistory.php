<?php

namespace StudentAssignmentScheduler\Classes;

use \Ds\{
    Stack,
    Map
};

use StudentAssignmentScheduler\Persistence\{
    Saveable,
    Retrievable,
    ImmutableModifiablePersistenceInterface
};

final class SpecialEventHistory implements Saveable, Retrievable, ImmutableModifiablePersistenceInterface
{
    /**
     * @var Stack $history
     */
    private $history;

    public function __construct(SpecialEventHistoryLocation $Location)
    {
        $this->history = \file_exists((string) $Location)
            ? $this->retrieve((string) $Location)->history()
            : new Stack();
    }
    
    public function __clone()
    {
        $this->history = $this->history->copy();
    }

    public function asMap(): Map
    {
        return new Map($this->history->toArray());
    }

    public function history(): Stack
    {
        return $this->history;
    }

    public function toArray(): array
    {
        return $this->history->toArray();
    }

    public function retrieve(string $location): object
    {
        return $this->getSavedSpecialEventHistory($location);
    }

    private function getSavedSpecialEventHistory(string $location): self
    {
        return \unserialize(
            \base64_decode(
                \file_get_contents($location)
            )
        );
    }

    /**
     * The instances of this class are immutable.
     *
     * @param SpecialEvent $item
     * @return static
     */
    public function add($item): ImmutableModifiablePersistenceInterface
    {
        return $this->addSpecialEvent($item);
    }

    private function addSpecialEvent(SpecialEvent $special_event): self
    {
        $copy = clone $this;

        $copy->history->push($special_event);

        return $copy;
    }

    /**
     * The instances of this class are immutable.
     *
     * @param SpecialEvent $item
     * @return static
     */
    public function remove($item): ImmutableModifiablePersistenceInterface
    {
        // since his implementation is using a stack
        // we do not use the $item parameter
        $copy = clone $this;

        $copy->history->pop();

        return $copy;
    }

    public function update($original_item, $new_item): ImmutableModifiablePersistenceInterface
    {
        // since we are using a stack, the original must be removed
        // before the new item is added
        return $this
            ->remove($original_item)
            ->add($new_item);
    }

    public function save(string $location): void
    {
        $serialized = \serialize($this);
        $encoded = \base64_encode($serialized);
        \file_put_contents($location, $encoded, LOCK_EX);
        chmod($location, 0600);
    }
}
