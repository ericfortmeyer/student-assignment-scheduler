<?php

namespace StudentAssignmentScheduler\Persistence;

interface Saveable
{
    /**
     * Stores the entity represented by the implementation.
     *
     * @param string $location Filename, key, or name depending on the implementation
     * @return void
     */
    public function save(string $location): void;
}
