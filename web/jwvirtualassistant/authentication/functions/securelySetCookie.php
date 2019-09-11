<?php

function securelySetCookie(string $name, string $value, int $exp, string $path = "", string $domain = ""): bool
{
    return setcookie($name, $value, $exp, $path, $domain, getConfigValue("HttpSecure"), true);
}
