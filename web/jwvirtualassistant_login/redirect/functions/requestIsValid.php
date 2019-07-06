<?php

use Psr\Http\Message\ServerRequestInterface;

use \Ds\Map;

function requestIsValid(ServerRequestInterface $request, string $query_param_key, string $access_token_key): bool
{
    $QueryParams = new Map($request->getQueryParams());
    return $QueryParams->hasKey($query_param_key) 
        && accessTokenIsValid(getAccessToken($QueryParams, $query_param_key, $access_token_key));
}

function getAccessToken(Map $QueryParams, string $param_key, string $access_token_key): string
{
    $authorizationResponse = $QueryParams->get($param_key, "oops");
    return json_decode($authorizationResponse, true)[$access_token_key];
}
