<?php

namespace TalkSlipSender;

class Contact
{
    public const FIRST_NAME = "first_name",
                 LAST_NAME  = "last_name",
                 EMAIL      = "email_address",
                 EMAIL_ADDRESS = "email_address";

    protected $first_name;
    protected $last_name;
    protected $email_address;

    public function __construct(string $first_name = "", string $last_name = "", string $email_address = "")
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email_address = $email_address;
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
