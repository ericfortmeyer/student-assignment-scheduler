<?php

namespace StudentAssignmentScheduler\FileNaming\Functions;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\{
    Fullname,
    Contact,
    ListOfContacts
};

use function StudentAssignmentScheduler\Bootstrapping\Functions\buildPath;

class AssignmentFormFilenameTest extends TestCase
{
    public function testFunctionComputesExpectedFilename()
    {
        $given_fullname = new Fullname("Thelonious Monk");
        $given_contact = new Contact("${given_fullname} tm@aol.com");
        $expected_filename = sha1($given_contact->guid()) . ".pdf";
        $list_of_contacts = new ListOfContacts([$given_contact]);
        $computedFilename = assignmentFormFilename($given_fullname, $list_of_contacts);
        $this->assertSame(
            $computedFilename,
            $expected_filename
        );
    }

    public function testFunctionComputesExpectedFilenameIfContactNotFound()
    {
        $given_list_of_contacts = new ListOfContacts();
        $given_fullname_text = "Nobody McMiller";
        $expected_fullname_text = "CONTACT_NOT_FOUND_" . str_replace(" ", "_", $given_fullname_text) . ".pdf";
        $given_fullname_to_find = new Fullname($given_fullname_text);
        $expected_filename = "CONTACT_NOT_FOUND_${expected_fullname_text}";
        $computedFilename = assignmentFormFilename($given_fullname_to_find, $given_list_of_contacts);
        $this->assertSame(
            $computedFilename,
            $expected_fullname_text
        );
    }
}
