<?php declare(strict_types=1);

function setSessionStream(string $session_name): bool {
    $expires = minutesToSeconds(5);
    return securelySetCookie($session_name, session_id(), $expires, "/");
}
