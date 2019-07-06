<?php

use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

require "vendor/autoload.php";

$Request = ServerRequest::fromGlobals();
$query_param_key = "authorizationResponse";
$access_token_key = "access_token";

if (!requestIsValid($Request, $query_param_key, $access_token_key)) {
    redirect(
        (new Uri(""))->withPath("/400ErrorPage.php")
    );
}

$access_token = json_decode($Request->getQueryParams()[$query_param_key], true)[$access_token_key];
setAuthorizationHeader($access_token);
redirect(
    (new Uri(""))
        ->withScheme("http")
        ->withHost("localhost")
        ->withPort("8080")
        ->withPath("templates-for-incomplete-months-of-assignments")
);
