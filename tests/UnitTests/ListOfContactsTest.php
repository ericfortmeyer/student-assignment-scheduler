<?php

namespace StudentAssignmentScheduler;

use PHPUnit\Framework\TestCase;

class ListOfContactsTest extends TestCase
{
    protected $ListOfContacts;
    protected $contacts = [];
    
    protected function setup(): void
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

    public function testListOfContactsReturnsExpectedContactWhenFound()
    {
        $given = new Contact("Molly Ringwald mr@aol.com");

        $list = new ListOfContacts([$given]);

        $cloneOfListThatShouldHaveSameValues = clone $list;

        $fullnameThatShouldNotMatch = new Fullname("Wrong Name");

        $fullnameThatShouldMatch = new Fullname("Molly Ringwald");

        $guidOfGivenContact = $given->guid();
        $guidThatShouldNotMatch = new Guid();

        $this->assertFalse(
            $list->findByFullname($fullnameThatShouldNotMatch)
        );

        $this->assertFalse(
            $list->findByGuid($guidThatShouldNotMatch)
        );

        $this->assertSame(
            $given,
            $list->findByGuid($guidOfGivenContact)
        );

        $this->assertSame(
            $given,
            $list->findByFullname($fullnameThatShouldMatch)
        );

        $this->assertSame(
            $given,
            $cloneOfListThatShouldHaveSameValues->findByFullname($fullnameThatShouldMatch)
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
        $fakeFirstName = "Added";
        $fakeLastName = "Person";
        $fakeEmail = "ap@fake.com";
        
        $this->assertTrue(
            $this->ListOfContacts->withContact(
                new Contact("${fakeFirstName} ${fakeLastName} ${fakeEmail}")
            )->contains("${fakeFirstName} ${fakeLastName}")
        );
    }

    public function testCanFindContactInListOfContactsBySha1OfGuid()
    {
        $given_guid = new Guid();
        $given_contact = new Contact("Thelonious Monk tmonk@aol.com");
        $guid_of_given_contact = $given_contact->guid();
        $given_sha1_of_guid = sha1((string) $guid_of_given_contact);
        $contacts = [
            $given_contact,
            new Contact("Jim Brown jb@aol.com"),
            new Contact("June Bug jbug@hotmail.com")
        ];
        $ListOfContacts = new ListOfContacts($contacts);
        $MaybeContact = $ListOfContacts->findBySha1OfGuid($given_sha1_of_guid);
        $returnFalse = function (): bool {
            return false;
        };
        $this->assertInstanceOf(
            Contact::class,
            $MaybeContact->getOrElse($returnFalse)
        );
        $this->assertTrue(
            $MaybeContact->getOrElse($returnFalse)->guid() === $guid_of_given_contact
        );
        $this->assertSame(
            $MaybeContact->getOrElse($returnFalse),
            $given_contact
        );
        $this->assertFalse(
            $MaybeContact->getOrElse($returnFalse) === new Contact("Thelonious Monk tmonk@aol.com")
        );
    }
}
