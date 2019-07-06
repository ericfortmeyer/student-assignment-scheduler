<?php

function accessTokenIsValid(string $access_token): bool
{
    $pattern = "/^[[:alnum:]]{30,40}$/";
    return (bool) preg_match($pattern, $access_token);
}
