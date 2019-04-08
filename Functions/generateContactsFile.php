<?php
/**
 * @phan-file-suppress PhanUndeclaredConstant
 */
namespace StudentAssignmentScheduler\Functions;

use \Ds\{
    Map,
    Vector,
    Set
};

function generateContactsFile(array $data, string $path_to_contacts_file)
{
    defineContants();

    $add_item = function (?string $carry, string $item): string {
        $string = __SPACES__ . "'${item}'";
        $append = __COMMA__ . PHP_EOL;
        return $carry
            ? $carry . $append . $string
            : $string;
    };

    $DuplicatesRemoved = new Set($data);

    $vector = new Vector($DuplicatesRemoved);

    $items = $vector->reduce($add_item);

    $file_content = $items ? formatDataForWriting($items) : contentForEmptyArray();

    file_put_contents($path_to_contacts_file, $file_content);
}

function defineContants(): void
{
    $constants = [
        "__COMMA__" => ",",
        "__OPEN_SQUARE_BRACKET__" => "[",
        "__CLOSED_SQUARE_BRACKET__" => "]",
        "__SEMICOLON__" => ";",
        "__RETURN_KEYWORD__" => "return",
        "__SPACES__" => "    ",
        "__PHP_TAG__" => "<?php",
        "__SPACE__" => " "
    ];

    $define = function (string $const, string $value) {
        // PhanUndeclaredVariable is raised by setting a variable with __NAMESPACE__ . "\\$const"
        defined(__NAMESPACE__ . "\\$const") || define(__NAMESPACE__ . "\\$const", $value);
    };

    (new Map($constants))->map($define);
}

function contentForEmptyArray(): string
{
    return __PHP_TAG__ . PHP_EOL . PHP_EOL . __RETURN_KEYWORD__ . __SPACE__
    . __OPEN_SQUARE_BRACKET__ . __CLOSED_SQUARE_BRACKET__ . __SEMICOLON__;
}

function formatDataForWriting(string $data_as_string): string
{
    return __PHP_TAG__ . PHP_EOL . PHP_EOL
        . __RETURN_KEYWORD__ . __SPACE__ . __OPEN_SQUARE_BRACKET__ . PHP_EOL
        . $data_as_string . PHP_EOL
        . __CLOSED_SQUARE_BRACKET__ . __SEMICOLON__ . PHP_EOL;
}
