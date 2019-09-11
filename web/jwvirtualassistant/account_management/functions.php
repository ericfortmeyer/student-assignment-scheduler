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

use \Ds\Vector;

function importFunctionsInDir(string $functions_dir): void
{
    $files = array_diff(scandir($functions_dir), [".", "..", "DS_Store"]);
    (new Vector($files))->map(
        function (string $filename) use ($functions_dir) {
            require $functions_dir . DIRECTORY_SEPARATOR . $filename;
        }
    );
}
$functions_directories = [
    __DIR__ . "/functions",
    __DIR__ . "/RequestRouting",
    __DIR__ . "/RequestValidation",
    __DIR__ . "/ResponseIntercepting"
];

(new Vector($functions_directories))->apply(
    function (string $function_dir): void {
        importFunctionsInDir($function_dir);
    }
);