<?php

namespace StudentAssignmentScheduler\Commands\Functions;

use \Dotenv\Dotenv;
use StudentAssignmentScheduler\Contact;

use function StudentAssignmentScheduler\Querying\Functions\getContacts;
use function StudentAssignmentScheduler\Bootstrapping\Functions\buildPath;
use function StudentAssignmentScheduler\Bootstrapping\Functions\setupKeys;
use function StudentAssignmentScheduler\Encryption\Functions\box;
use function StudentAssignmentScheduler\Encryption\Functions\secretKey;
use function StudentAssignmentScheduler\Encryption\Functions\masterKey;

/**
 * Adds an instance of Contact to the collection.
 *
 * @param Contact $contact
 * @return bool Returns whether or not adding to the collection was successful
 */
function addContact(Contact $contact, string $type): bool
{
    $rootDir = dirname(dirname(dirname(__DIR__)));

    try {
        $path_to_secrets = buildPath($rootDir, "data", "secrets");
        $env_dir = $rootDir;
        $secrets_vars = [
            "m",
            "s"
        ];
        $Dotenv = Dotenv::create($env_dir);
        $Dotenv->load();
    } catch (\Dotenv\Exception\InvalidPathException $e) {
        setupKeys($path_to_secrets, $env_dir);
        $Dotenv->load();
    }
    
    try {
        $Dotenv->required($secrets_vars);
    } catch (\Dotenv\Exception\ValidationException $e) {
        setupKeys($path_to_secrets, $env_dir);
        $Dotenv->load();
    }
    
    $contacts_dir = buildPath($rootDir, "data", "contacts");
    $contacts_file = buildPath(
        $contacts_dir,
        getNameByType($type)
    );

    $contacts = file_exists($contacts_file)
        ? getContacts(
            $contacts_file,
            getenv("m"),
            getenv("s")
        )
        : getInstanceByType($type, []);

    $returnValueOfPersisting = box(
        $contacts->union(
            getInstanceByType($type, [$contact])
        ),
        $contacts_file,
        secretKey(
            getenv("s"),
            masterKey(
                getenv("m")
            )
        )
    );

    // was the operation successful?
    return $returnValueOfPersisting > 0;
}
