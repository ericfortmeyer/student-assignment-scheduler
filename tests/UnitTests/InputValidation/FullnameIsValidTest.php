<?php

namespace StudentAssignmentScheduler\InputValidation\Functions;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\{
    Fullname,
    ListOfContacts
};

class FullnameIsValidTest extends TestCase
{
    public function testReturnsTrueIfValid()
    {
        $fakeFirstName = "Some";
        $fakeLastName = "Name";
        $fakeEmail = "faker@fakemail.com";

        $ListOfContacts = new ListOfContacts([
            "${fakeFirstName} ${fakeLastName} ${fakeEmail}"
        ]);

        $this->assertTrue(
            fullnameIsValid(
                new Fullname($fakeFirstName, $fakeLastName),
                $ListOfContacts
            )
        );
    }
}
