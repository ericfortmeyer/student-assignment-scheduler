<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
namespace StudentAssignmentScheduler;

use \Ds\Stack;
use \Ds\Map;
use \Ds\Vector;

use StudentAssignmentScheduler\Persistence\ImmutableModifiablePersistenceInterface;
use StudentAssignmentScheduler\Persistence\Saveable;

/**
 * A way of immutably persisting special events.
 */
final class SpecialEventHistory implements ImmutableHistoryInterface, Saveable, ImmutableModifiablePersistenceInterface
{
    /**
     * @var Stack $history
     */
    private $history;

    /**
     * Creates a SpecialEventHistory instance.
     *
     * @param SpecialEventHistoryLocation $Location Filename of the special event history
     */
    public function __construct(SpecialEventHistoryLocation $Location)
    {
        $this->history = \file_exists((string) $Location)
            ? $this->getSavedSpecialEventHistory((string) $Location)->history()
            : new Stack();
    }
    
    /**
     * A copy of the special event history.
     */
    public function __clone()
    {
        $this->history = $this->history->copy();
    }

    /**
     * Convert this instance into a map.
     *
     * @return Map
     */
    public function asMap(): Map
    {
        return new Map($this->history->toArray());
    }

    /**
     * Returns the history.
     *
     * @return Stack
     */
    public function history(): Stack
    {
        return $this->history;
    }

    /**
     * Returns the history as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->history->toArray();
    }

    /**
     * Returns a copy with the item removed.
     *
     * @param SpecialEvent $item
     * @return static
     */
    public function remove($item): ImmutableModifiablePersistenceInterface
    {
        // since this implementation is using a stack
        // we do not use the $item parameter
        $copy = clone $this;

        $copy->history->pop();

        return $copy;
    }

    /**
     * Returns a copy with the original item and the new item swapped.
     *
     * @param SpecialEvent $original_item
     * @param SpecialEvent $new_item
     * @return static
     */
    public function update($original_item, $new_item): ImmutableModifiablePersistenceInterface
    {
        // since we are using a stack, the original must be removed
        // before the new item is added
        return $this
            ->remove($original_item)
            ->with($new_item);
    }

    /**
     * Returns an instance that has been persisted.
     *
     * @param string $location
     * @return self
     */
    private function getSavedSpecialEventHistory(string $location): self
    {
        return \unserialize(
            \base64_decode(
                \file_get_contents($location)
            )
        );
    }

    /**
     * Add an item to the history.
     *
     * The instances of this class are immutable.
     *
     * @param Event $special_event
     * @return static
     */
    public function with(Event $special_event): ImmutableHistoryInterface
    {
        $copy = clone $this;
        $copy->history->push($special_event);
        return $copy;
    }

    /**
     * Retrieve the latest event.
     *
     * @return Event
     */
    public function latest(): Event
    {
        return $this->history()->pop();
    }

    /**
     * Does the instance have any future events.
     *
     * @return bool
     */
    public function hasFutureEvents(): bool
    {
        return !$this->history()->isEmpty()
            && !$this->history()->peek()->date()->isPast();
    }

    /**
     * Persists the SpecialEventHistory instance.
     *
     * Events are arranged in chronological order before saving.
     * @param string $location
     * @return void
     */
    public function save(string $location): void
    {
        $copy = clone $this;
        $copy->history = $this->sortEventsInChronologicalOrder($copy->history());

        $serialized = \serialize($copy);
        $encoded = \base64_encode($serialized);
        \file_put_contents($location, $encoded, LOCK_EX);
        chmod($location, 0600);
    }

    /**
     * Sorts events in chronological order.
     *
     * @param Stack $original_history
     * @return Stack The history after sorting
     */
    private function sortEventsInChronologicalOrder(Stack $original_history): Stack
    {
        $fromGreatestToLeast = function (SpecialEvent $a, SpecialEvent $b): int {
            return $a->date() <=> $b->date();
        };

        return new Stack(
            (new Vector($original_history))
                // since we are using a stack and want the greatest
                // date on the top of the stack, we will have to sort
                // from greatest to least
                ->sorted($fromGreatestToLeast)
        );
    }

    /**
     * Use to make the instance serializable to JSON.
     *
     * @return array
     */
    public function getArrayCopy(): array
    {
        return array_map(
            function (SpecialEvent $event): array {
                return $event->getArrayCopy();
            },
            $this->history()->toArray()
        );
    }
}
