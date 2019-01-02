<?php

namespace StudentAssignmentScheduler\Functions;

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

    $vector = new \Ds\Vector($data);

    $items = $vector->reduce($add_item);

    $file_content = formatDataForWriting($items);


    file_put_contents($path_to_contacts_file, $file_content);
}

function defineContants(): void
{
    define(__NAMESPACE__ . "\__COMMA__", ",");
    define(__NAMESPACE__ . "\__OPEN_SQUARE_BRACKET__", "[");
    define(__NAMESPACE__ . "\__CLOSED_SQUARE_BRACKET__", "]");
    define(__NAMESPACE__ . "\__SEMICOLON__", ";");
    define(__NAMESPACE__ . "\__RETURN_KEYWORD__", "return");
    define(__NAMESPACE__ . "\__SPACES__", "    ");
    define(__NAMESPACE__ . "\__PHP_TAG__", "<?php");
    define(__NAMESPACE__ . "\__SPACE__", " ");
}

function formatDataForWriting(string $data_as_string): string
{
    return __PHP_TAG__ . PHP_EOL . PHP_EOL
        . __RETURN_KEYWORD__ . __SPACE__ . __OPEN_SQUARE_BRACKET__ . PHP_EOL
        . $data_as_string . PHP_EOL
        . __CLOSED_SQUARE_BRACKET__ . __SEMICOLON__ . PHP_EOL;
}
