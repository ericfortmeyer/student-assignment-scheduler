<?php

namespace StudentAssignmentScheduler\Classes;

use PHPUnit\Framework\TestCase;

class ContactsTest extends TestCase
{
    public function testCanMatchContactToFullname()
    {
        $given = new Contact("Thelonious Monk tm@aol.com");

        $expectedMatchingFullnameOfContact = new Fullname("Thelonious", "Monk");

        $fullnameThatShouldNotMatchGivenContact = new Fullname("Thelonoius", "Money");

        $this->assertTrue(
            $given->is($expectedMatchingFullnameOfContact)
        );

        $this->assertFalse(
            $given->is($fullnameThatShouldNotMatchGivenContact)
        );
    }

    public function testContactCanBeTestedForEqualityAsValues()
    {
        $given = new Contact("King Kong aaaaaa@aol.com");

        $cloneThatIsTheSameValueAsGiven = clone $given;
        $newInstanceThatIsNotTheSameValueAsGiven = new Contact("King Kong aaaaaa@aol.com");
        $contactNotTheSameValueAsGiven = new Contact("King Klong aaaaaa@aol.com");

        $this->assertSame($given, $given);
        $this->assertEquals($given, $cloneThatIsTheSameValueAsGiven);
        $this->assertFalse($given == $newInstanceThatIsNotTheSameValueAsGiven);
    }

    public function testCanMatchContactToGuid()
    {
        $given = new Contact("Thelonious Monk tm@aol.com");

        $expectedGuidOfGivenContact = $given->guid();

        $this->assertTrue(
            $given->hasGuid(
                $expectedGuidOfGivenContact
            )
        );

        $this->assertFalse(
            $given->hasGuid(
                new Guid()
            )
        );
    }

    public function testAccessorsReturnExpectedValues()
    {
        $given = new Contact("Thelonious Monk tm@aol.com");
        $expected_contact_info = new \Ds\Vector([
            "Thelonious",
            "Monk",
            "tm@aol.com"
        ]);

        $this->assertInstanceOf(
            Guid::class,
            $given->guid()
        );
        // let's clone Guid the instance since
        // we will be forced to compare the Guid's 
        // value in the application instead of checking
        // to see if it's the same Guid instance
        $clone_of_guid = clone $given->guid();
        $new_guid_with_same_value = new Guid((string) $clone_of_guid);
        $this->assertTrue($given->hasGuid($clone_of_guid));
        $this->assertTrue($given->hasGuid($new_guid_with_same_value));
        $this->assertFalse($given->hasGuid(new Guid()));

        $this->assertSame(
            'Thelonious Monk',
            $given->fullname()
        );

        $this->assertSame(
            'Thelonious',
            $given->firstName()
        );

        $this->assertSame(
            'Monk',
            $given->lastName()
        );

        $this->assertTrue($given->is(new Fullname("Thelonious", "Monk")));

        $expected_contact_info->apply(
            (function (Contact $given) {
                return function (string $data_item) use ($given) {
                    $this->assertTrue(
                        $given->contains($data_item)
                    );
                };
            })($given)
        );
    }

    public function testThrowsInvalidArgumentException()
    {
        $array_of_invalid_data = new \Ds\Vector([
            "",
            "Al",
            "Al Bundy"
        ]);

        $attemptToCauseThrownException = function (string $invalid_data): void {
            try {
                new Contact($invalid_data);
            } catch (\InvalidArgumentException $e) {
                $this->assertTrue(true); // since it worked
            }
        };

        $array_of_invalid_data->map($attemptToCauseThrownException);

    }
}
