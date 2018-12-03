<?php

/**
 * Using realpath means the directories must already be created
 */
return [
    "path_to_data" => realpath(__DIR__ . "/../data"),
    "path_to_workbooks" => realpath(__DIR__ . "/../workbooks"),
    "path_to_schedules" => realpath(__DIR__ . "/../data/schedules"),
    "path_to_assignments" => realpath(__DIR__ . "/../data/assignments"),
    "path_to_forms" => realpath(__DIR__ . "/../data/forms"),
    "path_to_templates" => realpath(__DIR__ . "/../Utils/templates")
];
