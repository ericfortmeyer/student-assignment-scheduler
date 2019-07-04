<?php

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

    public function __toString()
    {
        return (string) $this->fullname;
    }
}
