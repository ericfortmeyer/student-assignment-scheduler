<?php declare(strict_types=1);

/**
 * @return string[] [$xsrf_token, $session_id]
 */
function fetchXSRFTokenAndSessionIdUsingGivenXSRFToken(string $xsrf_token): object {
    $stmt = getDatabase()->prepare("SELECT xsrf_token, session_id FROM login_xsrf_tokens WHERE xsrf_token = :xsrf_token");
    $stmt->execute([":xsrf_token" => $xsrf_token]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}
