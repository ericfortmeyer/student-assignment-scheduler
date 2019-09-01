<?php

namespace StudentAssignmentScheduler;

use \Ds\Set;
use \Ds\Map;
use \Ds\Vector;

/**
 * Used to aggregate a person's contact information.
 */
class Contact implements ArrayInterface
{
    /**
     * @var Guid $guid
     */
    public $guid;

    /**
     * @var string $first_name
     */
    public $first_name;
    
    /**
     * @var string $last_name
     */
    public $last_name;

    /**
     * @var Fullname $fullname
     */
    protected $fullname;
    
    /**
     * @var string $email_addrss
     */
    public $email_address;

    /**
     * @var Set $contact_info_index
     */
    protected $contact_info_index;

    /**
     * @param string $space_separated_contact_info
     */
    public function __construct(string $space_separated_contact_info = "", ?Guid $guid = null)
    {
        $separated = explode(" ", $space_separated_contact_info);
        
        [$first_name, $last_name, $email_address] = $this->validate($separated);
        $contact_info = $this->validate($separated);
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email_address = $email_address;
        $this->fullname = new Fullname($first_name, $last_name);
        $this->contact_info_index = new Set(array_merge($contact_info, [$this->fullname]));
        $this->guid = $guid ?? new Guid();
    }

    /**
     * @throws \InvalidArgumentException
     * @param array $contact_info
     * @return array Contact info
     */
    private function validate(array $contact_info): array
    {
        $contact_info_map = new Map($contact_info);
        [$first_name, $last_name, $email_address] = $this->getValues($contact_info_map);

        switch (false) {
            case $first_name:
                throw new \InvalidArgumentException(
                    $this->invalidArgumentMessage("First name", $contact_info)
                );
            case $last_name:
                throw new \InvalidArgumentException(
                    $this->invalidArgumentMessage("Last name", $contact_info)
                );
            case $email_address && \filter_var($email_address, FILTER_VALIDATE_EMAIL):
                throw new \InvalidArgumentException(
                    $this->invalidArgumentMessage("Email address", $contact_info)
                );
        }

        return [
            str_replace("_", " ", $first_name), $last_name, $email_address
        ];
    }

    private function getValues(Map $contact_info): array
    {
        // does the 'first name' include a middle initial
        return $contact_info->count() === 4
            ? [
                "{$contact_info->get(0, false)}_{$contact_info->get(1, false)}",
                $contact_info->get(2, false),
                $contact_info->get(3, false)
            ]
            : [
                $contact_info->get(0, false),
                $contact_info->get(1, false),
                $contact_info->get(2, false)
        ];
    }

    /**
     * @param string $type
     * @param array $contact_info
     * @return string
     */
    private function invalidArgumentMessage(string $type, array $contact_info): string
    {
        return "${type} not set in contact info for " . implode(" ", $contact_info);
    }


    /**
     * Does the contact match the Fullname?
     * @param Fullname $fullname
     * @return bool
     */
    public function is(Fullname $fullname): bool
    {
        return (string) $this->fullname === (string) $fullname;
    }

    /**
     * Does the contact match the Guid?
     * @param Guid $guid
     * @return bool
     */
    public function hasGuid(Guid $guid): bool
    {
        return $this->guid == $guid;
    }

    /**
     * Does the contact contain the value?
     * 
     * This operation performs a case insensitive search
     * for the given value.
     * @param string $value
     * @return bool
     */
    public function contains(string $value): bool
    {
        return (new Vector($this->contact_info_index))
            ->map(function (string $contact_info_item) { return strtolower($contact_info_item);})
            ->contains(strtolower($value));
    }
    
    public function guid(): Guid
    {
        return $this->guid;
    }

    /**
     * @return string
     */
    public function firstName(): string
    {
        return ucfirst($this->first_name);
    }

    /**
     * @return string
     */
    public function lastName(): string
    {
        return ucfirst($this->last_name);
    }

    /**
     * @return string
     */
    public function emailAddress(): string
    {
        return $this->email_address;
    }

    /**
     * @return string
     */
    public function fullname(): string
    {
        return (string) $this->fullname;
    }

    /**
     * @codeCoverageIgnore
     */
    public function __toString()
    {
        return "{$this->fullname()} {$this->emailAddress()}";
    }

    public function getArrayCopy(): array
    {
        return [
            "id" => (string) $this->guid(),
            "fullname" => $this->fullname(),
            "firstName" => $this->firstName(),
            "lastName" => $this->lastName(),
            "email" => $this->emailAddress()
        ];
    }

    public function exchangeArray($data): array
    {
        return is_string($data)
            ? (new self($data))->getArrayCopy()
            : (new self(implode(" ", $data)))->getArrayCopy();
    }
}
