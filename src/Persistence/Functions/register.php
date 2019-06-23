<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

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
