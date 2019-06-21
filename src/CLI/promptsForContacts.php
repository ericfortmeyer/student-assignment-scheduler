<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI;

function promptsForContacts(): array
{
    return [
        "first_name" => "Enter first name",
        "last_name" => "Enter last name",
        "email_address" => "Enter email address"
    ];
}
