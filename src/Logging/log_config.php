<?php

$log_dir = __DIR__ . "/../../log";

return [
    "email_log" => "${log_dir}/email.log",
    "file_save_log" => "${log_dir}/info.log",
    "file_import_log" => "${log_dir}/info.log",
    "invalid_file_log" => "${log_dir}/invalid_file.log"
];
