<?php declare(strict_types=1);

function setAuthSessionCookies(string $session_name, string $xsrf_token_name): array {
    return [
        initializeAuthSession($session_name), // first
        setAuthXSRFToken($xsrf_token_name, session_id()) // second
    ];
}
