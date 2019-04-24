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
}
