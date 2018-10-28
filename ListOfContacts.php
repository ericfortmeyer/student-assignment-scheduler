<?php

namespace TalkSlipSender;

class ListOfContacts
{
    public const NOT_SETUP_YET = "no emails set up yet",
                 TOO_MANY_EMAILS_RETURNED = "too many returned";
                
                 
    protected $contacts = [];

    public function are(): array
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact)
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

        $array_of_filtered_emails = $use_fullname === false
            ? array_filter(
                $haystack,
                function ($contact) use ($needle, $type) {
                    return $contact->get($type) === strtolower($needle);
                }
            )
            : array_filter(
                $haystack,
                function ($contact) use ($both) {
                    return $contact->get(Contact::FIRST_NAME) === strtolower($both[Contact::FIRST_NAME] ?? "")
                        && $contact->get(Contact::LAST_NAME) === strtolower($both[Contact::LAST_NAME] ?? "");
                }
            );

        return count($array_of_filtered_emails) > 1
                ? $this->throwTooManyReturned()
                : current($array_of_filtered_emails);
    }

    protected function throwTooManyReturned()
    {
        throw new \Exception(static::TOO_MANY_EMAILS_RETURNED);
    }
}
