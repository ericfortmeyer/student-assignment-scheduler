<?php

namespace StudentAssignmentScheduler\Classes;

class Contact
{
    public const FIRST_NAME = "first_name",
                 LAST_NAME  = "last_name",
                 EMAIL      = "email_address",
                 EMAIL_ADDRESS = "email_address";

    protected $first_name;
    protected $last_name;
    protected $email_address;

    public function __construct(string $space_separated_contact_info = "")
    {
        $separated = explode(" ", $space_separated_contact_info);
        list($first_name, $last_name, $email_address) = $this->validate($separated);

        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email_address = $email_address;
    }

    private function validate(array $contact_info): array
    {
        $contact_info_map = new \Ds\Map($contact_info);

        $first_name = strtolower($contact_info_map->get(0, false));
        $last_name = strtolower($contact_info_map->get(1, false));
        $email_address = strtolower($contact_info_map->get(2, false));

        switch (false) {
            case $first_name:
                throw new \InvalidArgumentException(
                    $this->invalidArgumentMessage("First name", $contact_info)
                );
            case $last_name:
                throw new \InvalidArgumentException(
                    $this->invalidArgumentMessage("Last name", $contact_info)
                );
            case $email_address:
                throw new \InvalidArgumentException(
                    $this->invalidArgumentMessage("Email address", $contact_info)
                );
        }

        return [
            $first_name, $last_name, $email_address
        ];
    }
    
    private function invalidArgumentMessage(string $type, array $contact_info): string
    {
        return "${type} not set in contact info for " . implode(" ", $contact_info);
    }

    public function addFirstName(string $first_name)
    {
        $this->first_name = strtolower($first_name);
    }

    public function addLastName(string $last_name)
    {
        $this->last_name = strtolower($last_name);
    }

    public function addEmailAddress(string $email_address)
    {
        $this->email_address = strtolower($email_address);
    }

    public function get(string $property): string
    {
        return $this->$property;
    }

    public function firstName(): string
    {
        return ucfirst($this->first_name);
    }

    public function emailAddress(): string
    {
        return $this->email_address;
    }

    public function fullname(): string
    {
        
        return ucwords("{$this->first_name} {$this->last_name}");
    }
}
