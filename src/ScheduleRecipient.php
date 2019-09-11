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

final class ScheduleRecipient extends Contact
{
    /**
     * @var Fullname $fullname
     */
    protected $fullname;

    public function __construct(string $contacts_info)
    {
        $info = explode(" ", $contacts_info);

        $this->first_name = $info[0];
        $this->last_name = $info[1];
        $this->fullname = new Fullname($this->first_name, $this->last_name);
        $this->guid = new Guid();
    }

    /**
     * Cast the instance to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fullname;
    }
}
