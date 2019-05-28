<?php

namespace StudentAssignmentScheduler\Persistence;

interface ImmutableModifiablePersistenceInterface
{
    public function add($item): self;
    public function remove($item): self;
    public function update($original_item, $new_item): self;
}
