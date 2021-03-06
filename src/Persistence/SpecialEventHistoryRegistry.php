<?php

namespace StudentAssignmentScheduler\Persistence;

use StudentAssignmentScheduler\{
    Destination,
    SpecialEventHistory,
    SpecialEventHistoryLocation
};
use \Ds\{
    Stack,
    Map
};

final class SpecialEventHistoryRegistry implements ImmutableRegistryInterface
{
    /**
     * @var Stack $names_of_histories
     */
    private $names_of_histories;

    /**
     * @var string $location_of_registry
     */
    private $location_of_registry;

    /**
     * @var Destination $location_of_special_events
     */
    private $location_of_special_events;

    public function __construct(string $location_of_registry, Destination $destination_of_special_events)
    {
        $this->location_of_registry = $location_of_registry;

        $this->location_of_special_events = $destination_of_special_events;

        $this->names_of_histories = \file_exists($location_of_registry)
            ? $this->read()
            : new Stack();
    }
    
    public function asMap(): Map
    {
        return new Map($this->names_of_histories);
    }

    public function toArray(): array
    {
        return $this->names_of_histories->toArray();
    }

    /**
     * Provides a representation of the contents of the registry.
     *
     * Returns a stack of names given to the special event histories
     * that have been persisted.
     *
     * @return Stack Names of histories
     */
    private function read(): Stack
    {
        return \unserialize(
            \base64_decode(
                \file_get_contents($this->pathToRegistry())
            )
        );
    }

    /**
     * Keep track of names of histories.
     *
     * The name is used to retrieve the latest history.
     * Use of instances of this class is for persisting
     * items immutably. The representation of instances
     * of this class are persisted after the item is
     * registered.
     *
     * Note: instances of this class are immutable.
     *
     * @param Saveable $saveable
     * @return static
     */
    public function register(Saveable $saveable): ImmutableRegistryInterface
    {
        $name_or_location_of_item_to_save = $this->itemName($saveable);

        $filename = new SpecialEventHistoryLocation(
            $this->location_of_special_events,
            $name_or_location_of_item_to_save
        );

        $saveable->save((string) $filename);
        
        $this
            ->registerSpecialEventHistory($name_or_location_of_item_to_save)
            ->write();

        // a new instance that represents what has just been persisted
        return new self($this->location_of_registry, $this->location_of_special_events);
    }

    /**
     * Retrieve the last item registered
     *
     * @return object
     */
    public function latest(): object
    {
        return $this->lastestSpecialEventHistoryOrNew();
    }

    private function lastestSpecialEventHistoryOrNew(): SpecialEventHistory
    {
        $name_or_location_of_latest = $this->names_of_histories->isEmpty()
           ? (function (): string {
               $name = $this->nameIfEmpty();
               $this->names_of_histories->push($name);
               return $name;
           })()
           : $this->names_of_histories->pop();

        $location = $this->locationOfLatestSpecialEventHistory($name_or_location_of_latest);

        return new SpecialEventHistory($location);
    }

    private function nameIfEmpty(): string
    {
        return $this->itemName(
            new SpecialEventHistory(
                new SpecialEventHistoryLocation(
                    new Destination($this->location_of_special_events),
                    "new"
                )
            )
        );
    }

    private function locationOfLatestSpecialEventHistory(
        string $name_or_location_of_latest
    ): SpecialEventHistoryLocation {
        return new SpecialEventHistoryLocation(
            $this->location_of_special_events,
            $name_or_location_of_latest
        );
    }
    
    private function itemName(object $history): string
    {
        return \sha1(
            serialize($history)
        );
    }

    /**
     * Register the "name" of the special event history.
     *
     * A string used to keep track of the location of the history
     * (hash, filename, etc).
     *
     * Note: instances of this class are immutable.
     *
     * @param string $name_of_special_event_history
     * @return self
     */
    private function registerSpecialEventHistory(string $name_of_special_event_history): self
    {
        $copy = clone $this;

        $copy->names_of_histories->push($name_of_special_event_history);

        return $copy;
    }

    private function write(): void
    {
        $serialized = \serialize($this->names_of_histories);
        $encoded = \base64_encode($serialized);
        \file_put_contents($this->pathToRegistry(), $encoded, LOCK_EX);
        chmod($this->pathToRegistry(), 0600);
    }

    private function pathToRegistry(): string
    {
        return $this->location_of_registry;
    }
}
