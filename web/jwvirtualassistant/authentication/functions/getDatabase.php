<?php declare(strict_types=1);

function getDatabase(): PDO {
    $session_database = getConfigValue("session_database");
    return new PDO("sqlite:${session_database}");
}
