<?php declare(strict_types=1);

function invalidXSRFTokenResponse(): string {
    header("HTTP/1.1 403 Bad request");
    header("Content-Type: application/json");
    $error_response = new class() {
        public $type = "http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html";
        public $title = "invalid_xsrf_token";
        public $status = 403;
        public $detail = "The XSRF token was invalid";
    };
    return json_encode($error_response);
}
