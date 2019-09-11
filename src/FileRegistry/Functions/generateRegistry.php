<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\FileRegistry\Functions;

define("__OPENING_TAG__", "<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 * 
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
");
define("__SPACE__", " ");
define("__INDENT__", "    ");
define("__RETURN__", "return");
define("__OPENING_BRACKET__", "[");
define("__CLOSING_BRACKET__", "]");
define("__ARROW__", "=>");
define("__COMMA__", ",");
define("__SEMICOLON__", ";");

function generateRegistry(array $data, string $filename = "")
{
    $path = __DIR__ . "/../";
    $registry_filename = $filename ? $filename : "${path}/registry";
    $string = "";
    $string .= __OPENING_TAG__;
    $string .= PHP_EOL;
    $string .= '// phpcs:ignoreFile';
    $string .= PHP_EOL;
    $string .= __RETURN__;
    $string .= __SPACE__;
    $string .= __OPENING_BRACKET__;
    foreach ($data as $key => $val) {
        $string .= PHP_EOL;
        $string .= __INDENT__;
        $string .= withQuotes($key);
        $string .= __SPACE__;
        $string .= __ARROW__;
        $string .= __SPACE__;
        $string .= withQuotes($val);
        $string .= __COMMA__;
    }
    $string = rtrim($string, __COMMA__);
    $string .= PHP_EOL;
    $string .= __CLOSING_BRACKET__;
    $string .= __SEMICOLON__;
    $file = $filename ? $filename : $registry_filename . ".php";

    /**
     * Necessary to run tests on builds without versioning the test registry.
     *
     * The registry is not committed since it exposes absolute paths
     * of files in the registry.
     */
    createDirectoryOfRegistryIfNotExists($file);
    file_put_contents($file, $string);
}

function createDirectoryOfRegistryIfNotExists(string $file): void
{
    $directory_of_registry = dirname($file);
    @mkdir($directory_of_registry, 0700);
}

function withQuotes(string $string): string
{
    return "\"${string}\"";
}
