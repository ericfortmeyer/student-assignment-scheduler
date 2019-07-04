<?php
/**
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
namespace StudentAssignmentScheduler;

use \Ds\Stack;
use \Ds\Map;
use \Ds\Vector;
use \Ds\Set;

use StudentAssignmentScheduler\Persistence\ImmutableModifiablePersistenceInterface;
use StudentAssignmentScheduler\Persistence\Saveable;

/**
 * A way of immutably persisting special events.
 */
class SpecialEventHistory implements
    ImmutableHistoryInterface,
    Saveable,
    ImmutableModifiablePersistenceInterface,
    ArrayInterface
{
    /**
     * @var Stack $history
     */
    private $history;

    /**
     * Creates a SpecialEventHistory instance.
     *
     * @param SpecialEventHistoryLocation|null $Location Filename of the special event history
     */
    public function __construct(?SpecialEventHistoryLocation $Location = null, ?Stack $history = null)
    {
        $this->history = \file_exists((string) $Location)
            ? $this->getSavedSpecialEventHistory((string) $Location)->history()
            : $history ?? new Stack();
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
     * Convert this instance into a set.
     *
     * @return Set
     */
    public function asSet(): Set
    {
        return new Set($this->history->toArray());
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
     * Returns a MaybeSpecialEvent instance.
     *
     * @param Guid $guid
     * @return MaybeSpecialEvent Represents the result of the search attempt
     */
    public function findByGuid(Guid $guid): MaybeSpecialEvent
    {
        $specialEventWithGuid = function (SpecialEvent $event) use ($guid): bool {
            return (string) $event->guid() === (string) $guid;
        };

        $result = $this->asSet()->filter($specialEventWithGuid);
        $resultResolved = $result->count() !== 0 ? $result->first() : false;

        return MaybeSpecialEvent::init($resultResolved);
    }

    /**
     * Returns a copy with the item removed.
     *
     * @param SpecialEvent $item
     * @return static
     */
    public function remove($item): ImmutableModifiablePersistenceInterface
    {
        $copy = clone $this;
        $historyAsSet = new Set($copy->history());
        $historyAsSet->remove($item);

        return $copy->withHistory(
            new Stack($historyAsSet)
        );
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
     * Return this instance with the given history.
     *
     * @param Stack $history
     * @return static
     */
    public function withHistory(Stack $history): ImmutableHistoryInterface
    {
        return new self(null, $history);
    }

    /**
     * @return Event
     */
    public function latest(): Event
    {
        return $this->history()->pop();
    }

    /**
     * @return bool
     */
    public function hasFutureEvents(): bool
    {
        return !$this->history()->isEmpty()
            && !$this->history()->peek()->date()->isPast();
    }

    /**
     * Persists the SpecialEventHistory instance
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

    public function getArrayCopy(): array
    {
        return array_map(
            function (SpecialEvent $event): array {
                return $event->getArrayCopy();
            },
            $this->history()->toArray()
        );
    }

    public function exchangeArray($array): array
    {
        return (new Stack($array))->toArray();
    }
}
