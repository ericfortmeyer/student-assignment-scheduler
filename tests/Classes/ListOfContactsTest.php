<?php

namespace StudentAssignmentScheduler\Classes;

use PHPUnit\Framework\TestCase;

class ListOfContactsTest extends TestCase
{
    protected $ListOfContacts;
    protected $contacts = [];
    
    protected function setup()
    {
        $this->contacts = require __DIR__ . "/../mocks/contacts.php";

        $this->ListOfContacts = new ListOfContacts($this->contacts);
    }

    public function testListOfContactsContainsName()
    {
        array_map(
            function (string $contact_info) {
                $contact = new Contact($contact_info);
                $this->assertTrue(
                    $this->ListOfContacts->contains($contact->fullname())
                );
            },
            $this->contacts
        );
    }

    public function testListOfContactsDoesNotContainName()
    {
        $this->assertFalse(
            $this->ListOfContacts->contains("Fake Person")
        );
    }

    public function testListOfContactsContainsAddedName()
    {
        $listClone = clone $this->ListOfContacts;
        $fakeFirstName = "Added";
        $fakeLastName = "Person";
        $fakeEmail = "ap@fake.com";
        
        $listClone->addContact(
            new Contact("${fakeFirstName} ${fakeLastName} ${fakeEmail}")
        );

        $this->assertTrue(
            $listClone->contains("${fakeFirstName} ${fakeLastName}")
        );
    }
}
