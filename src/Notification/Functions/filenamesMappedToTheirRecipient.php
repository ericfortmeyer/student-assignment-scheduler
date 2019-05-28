<?php

namespace StudentAssignmentScheduler\Notification\Functions;

use StudentAssignmentScheduler\{
    ListOfContacts,
    Contact,
    Guid
};
use \Ds\{
    Set,
    Map,
    Vector
};

function filenamesMappedToTheirRecipient(Set $filenames, ListOfContacts $contacts): Map
{
    $clone_of_list_of_contacts = clone $contacts;

    $mapFilenameToItsRecipient = function (
        string $original_filename,
        string $normalizedFilenames
    ) use ($clone_of_list_of_contacts): Contact {
        return $clone_of_list_of_contacts->findByGuid(new Guid($normalizedFilenames));
    };

    return normalizedFilenamesMappedToActualFilenames($filenames)->map($mapFilenameToItsRecipient);
}

function normalizedFilenamesMappedToActualFilenames(Set $original_filenames): Map
{
    $normalizedFilenames = (new Vector($original_filenames))->map(
        function (string $filename): string {
            $delimiter  = "_"; // allows filename_2.pdf,  filename_3.pdf
            $extension_to_remove = ".pdf";
            return basename(explode($delimiter, $filename)[0], $extension_to_remove);
        }
    );

    return new Map(
        array_combine($original_filenames->toArray(), $normalizedFilenames->toArray())
    );
}
