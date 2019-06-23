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

use \Ds\Set;

/**
 * A unique set of schedule recipient instances.
 */
final class ListOfScheduleRecipients extends ListOfContacts
{
    /**
     * Create the instance.
     *
     * @param string[] $contacts
     */
    public function __construct(array $contacts)
    {
        $this->contacts = new Set(
            array_map(
                function (string $contact_info): ScheduleRecipient {
                    return new ScheduleRecipient($contact_info);
                },
                $contacts
            )
        );
    }
}
