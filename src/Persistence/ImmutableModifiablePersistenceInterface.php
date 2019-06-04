<?php

namespace StudentAssignmentScheduler\Persistence;

interface ImmutableModifiablePersistenceInterface
{
    public function remove($item): self;
    public function update($original_item, $new_item): self;
    public function toArray(): array;
    public function asMap(): \Ds\Map;
}
