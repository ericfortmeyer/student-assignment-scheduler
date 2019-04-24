<?php

namespace StudentAssignmentScheduler\Classes;

final class ScheduleRecipient extends Contact
{
    /**
     * @var string $first_name
     */
    protected $first_name = "";
    
    /**
     * @var string $last_name
     */
    protected $last_name = "";

    /**
     * @var Fullname $fullname
     */
    protected $fullname;

    /**
     * @var Guid $guid
     */
    protected $guid;

    protected $email_address = "";

    public function __construct(string $contacts_info)
    {
        $info = explode(" ", $contacts_info);

        $this->first_name = $info[0];
        $this->last_name = $info[1];
        $this->fullname = new Fullname($this->first_name, $this->last_name);
        $this->guid = new Guid();
    }
}
