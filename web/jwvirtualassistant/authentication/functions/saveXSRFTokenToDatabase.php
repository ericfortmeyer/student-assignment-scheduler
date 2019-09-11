<?php declare(strict_types=1);

function saveXSRFTokenToDatabase(string $xsrf_token, string $session_id): bool {
    return getDatabase()
        ->prepare("INSERT INTO login_xsrf_tokens VALUES(:xsrf_token, :session_id, DATETIME('now'))")
        ->execute([":xsrf_token" => $xsrf_token, ":session_id" => $session_id]);
}
