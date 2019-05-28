<?php

namespace StudentAssignmentScheduler\Persistence\Functions;

use StudentAssignmentScheduler\Persistence\{
    Saveable,
    ImmutableRegistryInterface
};

function register(Saveable $modified_saveable): \Closure
{
    return (function (Saveable $modified_saveable): \Closure {
        return function (ImmutableRegistryInterface $registry) use ($modified_saveable): void {
            $registry->register($modified_saveable);
        };
    })($modified_saveable);
}
