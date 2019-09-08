<?php

namespace StudentAssignmentScheduler\Notification\Functions;

use PHPUnit\Framework\TestCase;

use \Ds\{
    Vector,
    Map,
    Set
};

use StudentAssignmentScheduler\{
    ListOfContacts,
    Contact,
    Fullname,
    Guid
};
use function StudentAssignmentScheduler\FileNaming\Functions\{
    jsonAssignmentFilename,
    assignmentFormFilename
};

class FilenamesMappedToContactsTest extends TestCase
{
    /**
     * @var ListOfContacts
     */
    protected $list_of_contacts;
    
    /**
     * Individual contacts below
     *
     * @var Contact
     */
    protected $a;
    protected $b;
    protected $c;
    protected $d;

    protected $files_to_delete = [];
    protected $expected_filenames = [];

    protected function setup(): void
    {
        $fullnames = [$a, $b, $c, $d] = [
            new Fullname("Thelonious Monk"),
            new Fullname("Art Tatum"),
            new Fullname("Oscar Patterson"),
            new Fullname("Duke Ellington")
        ];

        $this->contacts = [$this->a, $this->b, $this->c, $this->d] = [
            new Contact("${a} tm@aol.com"),
            new Contact("${b} at@aol.com"),
            new Contact("${c} op@aol.com"),
            new Contact("${d} theduke@gmail.com")
        ];

        $this->list_of_contacts = $ListOfContacts = new ListOfContacts($this->contacts);

        $this->destination_of_files = __DIR__ . "/../../../tmp";

        $writeFiles = function (Fullname $fullname) use ($ListOfContacts): void {
            $this->expected_filenames[] = $this->files_to_delete[] = $filename =
                $this->destination_of_files . DIRECTORY_SEPARATOR . assignmentFormFilename($fullname, $ListOfContacts);
            \file_put_contents($filename, (string) $fullname, LOCK_EX);
        };

        (new Vector($fullnames))->map($writeFiles);
    }

    public function testFilenameToContactMappingIsAsExpected()
    {
        $expected_map = new Map(array_combine($this->expected_filenames, $this->contacts));
        $set_of_filenames_with_prepended_values = new Set([
            $this->destination_of_files . "/" . sha1($this->a->guid()) . "_2.pdf",
            $this->destination_of_files . "/" . sha1($this->b->guid()) . "_2.pdf",
            $this->destination_of_files . "/" . sha1($this->c->guid()) . "_2.pdf",
            $this->destination_of_files . "/" . sha1($this->d->guid()) . "_2.pdf",
        ]);

        $set_of_given_filenames = (new Set($this->expected_filenames))->union($set_of_filenames_with_prepended_values);
        $ListOfContacts = new ListOfContacts($this->contacts);

        $this->assertEquals(
            $expected_map,
            $result = filenamesMappedToTheirRecipient(
                $set_of_given_filenames,
                $ListOfContacts
            )
        );
    }

    protected function teardown(): void
    {
        array_map(
            function (string $filename): void {
                unlink($filename);
            },
            $this->files_to_delete
        );
    }
}
