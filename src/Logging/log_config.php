<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

$log_dir = __DIR__ . "/../../log";

return [
    "email_log" => "${log_dir}/email.log",
    "file_save_log" => "${log_dir}/info.log",
    "file_import_log" => "${log_dir}/info.log",
    "invalid_file_log" => "${log_dir}/invalid_file.log"
];
