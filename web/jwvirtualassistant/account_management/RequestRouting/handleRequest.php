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

use const jwvirtualassistant\AccountManagement\DATABASE_FILE;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;
use \PDO;

function handleRequest(ServerRequestInterface $request): ResponseInterface
{
    $db = new PDO(
        sprintf("sqlite:%s", DATABASE_FILE)
    );

    switch (true) {
        case shouldUpdatePassword($request):
            return updatePasswordAction($request, $db);
        case shouldCreateAccount($request):
            return createAccountAction($request, $db);
        default:
            return new Response(404);
    }
}
