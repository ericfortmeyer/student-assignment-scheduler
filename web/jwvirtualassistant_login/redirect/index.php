<?php

use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Dotenv\Dotenv;

require "vendor/autoload.php";

$Dotenv = Dotenv::create(__DIR__);
$Dotenv->load();
$Request = ServerRequest::fromGlobals();
define("AUTH_PARAM_KEY", getenv("AUTHORIZATION_RESPONSE_QUERY_PARAM_KEY"));
define("ACCESS_TOKEN_KEY", getenv("ACCESS_TOKEN_KEY"));
define("_400_ERROR_PAGE", getenv("_400_ERROR_PAGE"));
define("RESOURCE_SERVER", getenv("RESOURCE_SERVER"));

if (!requestIsValid($Request, AUTH_PARAM_KEY, ACCESS_TOKEN_KEY)) {
    redirect(
        (new Uri())->withPath(_400_ERROR_PAGE)
    );
}

$access_token = json_decode($Request->getQueryParams()[AUTH_PARAM_KEY], true)[ACCESS_TOKEN_KEY];
setAuthorizationHeader($access_token);
redirect((new Uri(RESOURCE_SERVER)));
