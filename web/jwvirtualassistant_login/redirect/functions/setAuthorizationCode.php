<?php

function setAuthorizationHeader(string $access_token): void
{
    header(sprintf("Authorization: Bearer %s", $access_token));
}
