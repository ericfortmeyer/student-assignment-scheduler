<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
 declare(strict_types=1);

namespace StudentAssignmentScheduler\Notification\Functions;

use StudentAssignmentScheduler\{
    ListOfContacts,
    MaybeContact
};
use \Ds\{
    Set,
    Map,
    Vector
};

/**
 * Return a Map of key value pairs
 *
 * The maps keys are the filenames and the values are a MaybeContact instance.
 * The MaybeContact instance represents the result of either finding or not
 * finding a Contact.
 *
 * @param Set $filenames
 * @param ListOfContacts $contacts
 * @return Map<string,Contact>
 */
function filenamesMappedToTheirRecipient(Set $filenames, ListOfContacts $contacts): Map
{
    $clone_of_list_of_contacts = clone $contacts;

    $mapFilenameToItsRecipient = function (
        string $original_filename,
        string $normalizedFilenames
    ) use ($clone_of_list_of_contacts): MaybeContact {
        $sha1_of_guid = $normalizedFilenames;
        return $clone_of_list_of_contacts->findBySha1OfGuid($sha1_of_guid);
    };

    return normalizedBasenamesOfFilesMappedToFullFilenames($filenames)->map($mapFilenameToItsRecipient);
}

/**
 * Remove the extension and numbers appended to the filename
 *
 * @param Set $original_filenames
 * @return Map
 */
function normalizedBasenamesOfFilesMappedToFullFilenames(Set $original_filenames): Map
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
