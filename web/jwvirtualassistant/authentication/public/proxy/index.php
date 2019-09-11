<?php
/**
 * =========================
 * Proxy for XSRF mitigation.
 * =========================
 * 
 * 
 * Validates the login session and
 * the XSRF token before sending the request
 * to the authentication server.
 * 
 * An attacker using a malicious website in a user's
 * browser would not be able to login.
 * @link https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html
 * 
 * POST data will be validated on the authentication
 * server instead of this proxy.
 */
require __DIR__ . "/../../functions.php";

try {
    parse_str(file_get_contents("php://input"), $post_data);
    print XSRFTokenIsValid(getXSRFTokenFromHeader())
        ? sendRequestToAuthServer($post_data)
        : invalidXSRFTokenResponse();
} catch (\Throwable $error) {
    print json_encode($error->getMessage());
}
