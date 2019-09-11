<?php declare(strict_types=1);

function setXSRFToken(string $xsrf_token_name, string $value_to_hash): bool {
    $token = generateXSRFToken($value_to_hash);
    // return setcookie($xsrf_token_name, $token, minutesToSeconds())
    return securelySetCookie($xsrf_token_name, $token, minutesToSeconds(30), "/");
}
