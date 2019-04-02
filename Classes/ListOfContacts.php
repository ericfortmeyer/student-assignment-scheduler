<?php

namespace StudentAssignmentScheduler\Classes;

class ListOfContacts
{
    public const NOT_SETUP_YET = "no emails set up yet",
                 TOO_MANY_EMAILS_RETURNED = "too many returned";
                
                 
    protected $contacts = [];

    public function __construct(array $contacts = [])
    {
        $this->contacts = array_map(
            function (string $contact_info): Contact {
                return new Contact($contact_info);
            },
            $contacts
        );
    }

    public function are(): array
    {
        return $this->contacts;
    }

    public function contains(string $value): bool
    {
        return $this->getContactByFirstName($value)
            || $this->getContactByLastName($value)
            || $this->getContactByEmailAddress($value)
            || (function (array $nameSplit) {
                    return count($nameSplit) > 1
                        ? $this->getContactByFullName($nameSplit[0], $nameSplit[1])
                        : false;
            })(explode(" ", $value));
    }

    public function addContact(Contact $contact): void
    {
        $this->contacts[] = $contact;
    }

    public function getContactByFirstName(string $first_name)
    {
        return $this->searchByType($this->contacts, CONTACT::FIRST_NAME, $first_name);
    }

    public function getContactByLastName(string $last_name)
    {
        return $this->searchByType($this->contacts, CONTACT::LAST_NAME, $last_name);
    }

    public function getContactByEmailAddress(string $email_address)
    {
        return $this->searchByType($this->contacts, Contact::EMAIL_ADDRESS, $email_address);
    }

    public function getContactByFullName(string $first_name, string $last_name)
    {
        return $this->searchByType(
            $this->contacts,
            "",
            "",
            true,
            [
                Contact::FIRST_NAME => $first_name,
                Contact::LAST_NAME => $last_name
            ]
        );
    }

    /**
     *
     * @return Contact|bool
     */
    protected function searchByType(
        array $haystack,
        string $type = "",
        string $needle = "",
        bool $use_fullname = false,
        array $both = [Contact::FIRST_NAME => "", Contact::LAST_NAME => ""]
    ) {
        if (empty($haystack)) {
            throw new \Exception(static::NOT_SETUP_YET);
        }

        $result = $use_fullname === false
            ? array_filter(
                $haystack,
                function ($contact) use ($needle, $type) {
                    return $contact->get($type) === strtolower($needle);
                }
            )
            : array_filter(
                $haystack,
                function ($contact) use ($both) {
                    return $contact->get(Contact::FIRST_NAME) === strtolower($both[Contact::FIRST_NAME])
                        && $contact->get(Contact::LAST_NAME) === strtolower($both[Contact::LAST_NAME]);
                }
            );

        return count($result) > 1
                ? $this->throwTooManyReturned()
                : current($result);
    }

    protected function throwTooManyReturned()
    {
        throw new \Exception(static::TOO_MANY_EMAILS_RETURNED);
    }
}
