<?php declare(strict_types=1);

function XSRFTokenIsValid(string $xsrf_token): bool {
    // they check below will validate so we can silence errors here
    $result = fetchXSRFTokenAndSessionIdUsingGivenXSRFToken($xsrf_token);
    return $result->xsrf_token === generateXSRFToken($result->session_id);
}
