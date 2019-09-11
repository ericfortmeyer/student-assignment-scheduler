<?php declare(strict_types=1);

function setAuthXSRFToken(string $xsrf_token_name, string $value_to_hash): string {
    $token = generateXSRFToken($value_to_hash);
    setcookie($xsrf_token_name, $token, minutesToSeconds(60 * 5), "/", "", false);
    return $token;
}
