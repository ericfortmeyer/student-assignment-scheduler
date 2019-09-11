<?php declare(strict_types=1);
/**
 * This file is a part of JW Virtual Assistant Login Account Management.
 * 
 * Copywright (c) Eric Fortmeyer.
 * See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace jwvirtualassistant\AccountManagement;

use GuzzleHttp\Psr7\ServerRequest;
use Narrowspark\HttpEmitter\SapiEmitter;

$BASE_DIR = __DIR__ . "/../../";

require "${BASE_DIR}vendor/autoload.php";

$Emitter = new SapiEmitter();
$Request = ServerRequest::fromGlobals();
$Response = RequestRouting\handleRequest($Request);
ResponseIntercepting\interceptRedirect($Response);
$Emitter->emit($Response);
