<?php declare(strict_types=1);

function initializeAuthSession(string $session_name): string {
    session_name($session_name);
    session_start();
    setAuthSessionStream($session_name);
    return session_id();
}
