<?php

namespace StudentAssignmentScheduler\Commands\Functions;


use \Dotenv\Dotenv;

use StudentAssignmentScheduler\Guid;

use function StudentAssignmentScheduler\Bootstrapping\Functions\buildPath;
use function StudentAssignmentScheduler\Bootstrapping\Functions\setupKeys;
use function StudentAssignmentScheduler\Querying\Functions\getContacts;
use function StudentAssignmentScheduler\Encryption\Functions\box;
use function StudentAssignmentScheduler\Encryption\Functions\secretKey;
use function StudentAssignmentScheduler\Encryption\Functions\masterKey;

function deleteContact(Guid $guid, string $type): bool
{
    $rootDir = dirname(dirname(dirname(__DIR__)));

    try {
        $path_to_secrets = buildPath($rootDir, "data", "secrets");
        $env_dir = $rootDir;
        $secrets_vars = [
            "m",
            "s"
        ];
        $Dotenv = new Dotenv($env_dir);
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
    $contacts_file = buildPath($contacts_dir, getNameByType($type));

    $contacts = getContacts(
        $contacts_file,
        getenv("m"),
        getenv("s")
    );

    $contact = $contacts
        ->findByGuid($guid)
        ->getOrElse(
            function (): bool {
                return false;
            }
        );

    if ($contact === false) {
        return false;
    }

    $contacts->remove($contact);
    
    box(
        $contacts,
        $contacts_file,
        secretKey(
            getenv("s"),
            masterKey(
                getenv("m")
            )
        )
    );
    return true;
}
