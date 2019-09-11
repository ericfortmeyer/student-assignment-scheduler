<?php declare(strict_types=1);

function getXSRFTokenFromHeader(string $xsrf_header_name = "X-Xsrf-Token"): string {
    return urldecode(getallheaders()[$xsrf_header_name]);
}
