<?php

namespace StudentAssignmentScheduler\Querying\Functions;

use \Dotenv\Dotenv;
use function StudentAssignmentScheduler\Bootstrapping\Functions\buildPath;
use function StudentAssignmentScheduler\Bootstrapping\Functions\setupKeys;

function fetchContacts()
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
    $contacts_file = buildPath($contacts_dir, "contacts");

    $contacts = getContacts(
        $contacts_file,
        getenv("m"),
        getenv("s")
    );

    $collection = new \StudentAssignmentScheduler\ListOfContacts($contacts->toArray());

    return $collection->getArrayCopy();
}
