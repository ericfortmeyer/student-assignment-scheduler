<?php

namespace StudentAssignmentScheduler\Classes;

use \Ds\Set;

class ListOfContacts
{
    public const NOT_SETUP_YET = "no emails set up yet",
                 TOO_MANY_EMAILS_RETURNED = "too many returned";
                
    /**
     * @var Set $contacts
     */
    protected $contacts;

    public function __construct(array $contacts = [])
    {
        $this->contacts = new Set(array_map(
            function (string $contact_info): Contact {
                return new Contact($contact_info);
            },
            $contacts
        ));
    }

    public function are(): array
    {
        return $this->contacts->toArray();
    }

    public function toSet(): Set
    {
        return $this->contacts;
    }

    public function get(int $index): Contact
    {
        return $this->contacts->get($index);
    }

    public function remove(Contact $contact): void
    {
        $this->contacts->remove($contact);
    }

    public function union(self $ListOfContacts): self
    {
        $copyOfContacts = clone $this;
        $copyOfContacts->contacts = $copyOfContacts
            ->toSet()
            ->union(
                $ListOfContacts->toSet()
            );
        return $copyOfContacts;
    }

    public function reduce(\Closure $callable)
    {
        return $this->contacts->reduce($callable);
    }

    public function toArray(): array
    {
        return $this->contacts->toArray();
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
        $this->contacts->add($contact);
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
     * @suppress PhanTypeMismatchReturn
     * @throws \Exception
     * @return Contact
     */
    protected function searchByType(
        Set $haystack,
        string $type = "",
        string $needle = "",
        bool $use_fullname = false,
        array $both = [Contact::FIRST_NAME => "", Contact::LAST_NAME => ""]
    ): Contact {
        if ($haystack->isEmpty()) {
            throw new \Exception(static::NOT_SETUP_YET);
        }

        return $use_fullname === false
            ? $haystack->filter(
                function ($contact) use ($needle, $type): bool {
                    return $contact->get($type) === strtolower($needle);
                }
            )->first()
            : $haystack->filter(
                function ($contact) use ($both): bool {
                    return $contact->get(Contact::FIRST_NAME) === strtolower($both[Contact::FIRST_NAME])
                        && $contact->get(Contact::LAST_NAME) === strtolower($both[Contact::LAST_NAME]);
                }
            )->first();
    }

    protected function throwTooManyReturned()
    {
        throw new \Exception(static::TOO_MANY_EMAILS_RETURNED);
    }
}
