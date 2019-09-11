<?php declare(strict_types=1);
/**
 * This file is a part of JW Virtual Assistant Login Account Management.
 * 
 * Copywright (c) Eric Fortmeyer.
 * See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */


namespace jwvirtualassistant\AccountManagement\RequestRouting;

use Psr\Http\Message\ServerRequestInterface;

function shouldUpdatePassword(ServerRequestInterface $Request): bool
{
    $query_params = $Request->getQueryParams();
    $parsed_body = $Request->getParsedBody();
    return $Request->getMethod() === "POST"
        && key_exists("username", $query_params)
        && key_exists("account_secret", $query_params)
        && key_exists("password", $parsed_body);
}