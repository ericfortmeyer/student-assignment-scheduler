<?php

namespace TalkSlipSender\FileRegistry\Functions;

define("__OPENING_TAG__", "<?php");
define("__SPACE__", " ");
define("__INDENT__", "    ");
define("__RETURN__", "return");
define("__OPENING_BRACKET__", "[");
define("__CLOSING_BRACKET__", "]");
define("__ARROW__", "=>");
define("__COMMA__", ",");
define("__SEMICOLON__", ";");

function generateRegistry(array $data, string $filename = "", $asJSON = false)
{
    $path = __DIR__ . "/../";
    $registry_filename = $filename ? $filename : "${path}/registry";

    if ($asJSON === true) {
        $file = "${registry_filename}.json";
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    } else {
    
        $string = "";
        $string .= __OPENING_TAG__;
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
            $string .= is_array($val) ? valAsArray($val) : withQuotes($val);
            $string .= __COMMA__;
        }
        
        $string = rtrim($string, __COMMA__);
    
        $string .= PHP_EOL;
        $string .= __CLOSING_BRACKET__;
        $string .= __SEMICOLON__;
        $file = $filename ? $filename : $registry_filename . ".php";
        file_put_contents($file, $string);
    }
}

function withQuotes(string $string): string
{
    return "\"" . $string . "\"";
}

function valAsArray(array $data): string
{
    $string = "";
    $string .= __OPENING_BRACKET__;
    $string .= PHP_EOL;
    $string .= __INDENT__;
    $string .= __INDENT__;
    foreach ($data as $key => $val) {
        $string .= withQuotes($key);
        $string .= __SPACE__;
        $string .= __ARROW__;
        $string .= __SPACE__;
        $string .= withQuotes($val);
        $string .= __COMMA__;
        $string .= PHP_EOL;
        $string .= __INDENT__;
        $string .= __INDENT__;
    }
    $string = rtrim(trim($string), __COMMA__ . PHP_EOL);
    $string .= PHP_EOL;
    $string .= __INDENT__;
    $string .= __CLOSING_BRACKET__;
    return $string;
}
