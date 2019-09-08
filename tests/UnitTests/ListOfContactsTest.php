<?php

namespace StudentAssignmentScheduler;

use PHPUnit\Framework\TestCase;

class ListOfContactsTest extends TestCase
{
    protected $ListOfContacts;
    protected $contacts = [];
    
    protected function setup(): void
    {
        $this->contacts = [
            "Bob Smith bob@aol.com",
            "Thelonious Monk tmonk@hotmail.com",
            "Art Tatum tatum@gmail.com",
            "Oscar Peterson op@gmail.com"
        ];
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
            $list->findByFullname($fullnameThatShouldNotMatch)->getOrElse(
                function (): bool {
                    return false;
                }
            )
        );

        $this->assertFalse(
            $list->findByGuid($guidThatShouldNotMatch)->getOrElse(
                function (): bool {
                    return false;
                }
            )
        );

        $this->assertSame(
            $given,
            $list->findByGuid($guidOfGivenContact)->getOrElse(
                function (): bool {
                    return false;
                }
            )
        );

        $this->assertSame(
            $given,
            $list->findByFullname($fullnameThatShouldMatch)->getOrElse(
                function (): bool {
                    return false;
                }
            )
        );

        $this->assertSame(
            $given,
            $cloneOfListThatShouldHaveSameValues
                ->findByFullname($fullnameThatShouldMatch)
                ->getOrElse(
                    function (): bool {
                        return false;
                    }
                )
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

    public function testCanFindContactIfGivenFirstNameHasMultipleCapitalLetters()
    {
        $first_names_with_multiple_capital_letters = [
            "DJ",
            "TJ",
            "BB",
            "BoDee",
            "AmyLee"
        ];

        $normal_first_names = [
            "Mary",
            "Sue",
            "Catherine",
            "Thelonious"
        ];

        $fake_last_name = "Fake";
        $fake_email = "fake@aol.com";

        /**
         * @var Contact[] $fake_contacts
         */
        $fake_contacts = array_map(
            function (string $first_name) use ($fake_last_name, $fake_email): Contact {
                return new Contact("${first_name} ${fake_last_name} ${fake_email}");
            },
            array_merge($first_names_with_multiple_capital_letters, $normal_first_names)
        );

        $FakeListOfContacts = new ListOfContacts($fake_contacts);

        $this->assertFalse(
            $FakeListOfContacts->findByFullname(new Fullname("Eric Fortmeyer"))->getOrElse(
                function () {return false;}
            )
        );


        array_map( 
            function (string $given_first_name) use ($FakeListOfContacts, $fake_last_name): void {
                $this->assertThat(
                    $FakeListOfContacts
                        ->findByFullname(new Fullname($given_first_name, $fake_last_name))
                        ->getOrElse(function () { return false; }),
                    $this->logicalNot(
                        $this->equalTo(false)
                    )
                );
            },
            array_merge($first_names_with_multiple_capital_letters, $normal_first_names)
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
