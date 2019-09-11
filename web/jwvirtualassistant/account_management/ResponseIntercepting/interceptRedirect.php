<?php declare(strict_types=1);
/**
 * This file is a part of JW Virtual Assistant Login Account Management.
 * 
 * Copywright (c) Eric Fortmeyer.
 * See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace jwvirtualassistant\AccountManagement\ResponseIntercepting;

use Psr\Http\Message\ResponseInterface;

function interceptRedirect(ResponseInterface $response): void
{
    if ($response->hasHeader("Location")) {
        header(sprintf("Location: %s", $response->getHeaderLine("Location")));
        exit();
    }
}
