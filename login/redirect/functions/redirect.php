<?php

use Psr\Http\Message\UriInterface;

function redirect(UriInterface $url): void
{
    header(sprintf("Location: %s", (string) $url));
}
