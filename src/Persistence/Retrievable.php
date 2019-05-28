<?php

namespace StudentAssignmentScheduler\Persistence;

interface Retrievable
{
    /**
     * Retrieve the entity represented by the implementation.
     *
     * @param string $location Filename, key, or name depending on the implementation
     * @return iterable
     */
    public function retrieve(string $location): object;
}
