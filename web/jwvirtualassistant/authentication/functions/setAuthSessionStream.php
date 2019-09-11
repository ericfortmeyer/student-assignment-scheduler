<?php declare(strict_types=1);

function setAuthSessionStream(string $session_name): bool {
    $expires = minutesToSeconds(60 * 5);
    return securelySetCookie($session_name, session_id(), $expires, "/");
}
