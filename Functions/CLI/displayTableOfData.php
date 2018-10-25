<?php

namespace TalkSlipSender\Functions\CLI;

function displayTableOfData(array $data): bool
{

    $values = $headers = "";
    $result = false;


    foreach ($data as $key => $value) {
        if (is_array($value)) {
            continue;
        }

        if ($key !== "year") {
            $padded = str_pad($key, strlen($value), " ", STR_PAD_BOTH);
            $headers .= green("|") . " ${padded} ";
        }
    }
    $line = $headers ? str_repeat("-", (int) round(strlen($headers) * 0.64)) . "\r\n" : "";
    print green($line);

    print $headers;
    $headers ? print green("|\r\n") : null;

    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $result = displayTableOfData($value);
            continue;
        }
        if ($key == "year") {
            continue;
        }
        $val_padded = str_pad($value, strlen($key), " ", STR_PAD_BOTH);
        $values .= green("|") . " ${val_padded} ";
    }
    print $values;
    $values ? print green("|\r\n") : null;
    print green(str_repeat("_", (int) round(strlen($headers) * 0.64))) . "\r\n";

    return !empty($data) || $result;
}
