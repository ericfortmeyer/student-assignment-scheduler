<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Querying\Functions;

use function StudentAssignmentScheduler\Utils\Functions\getConfig;

function getAppId(): string
{
    $config = getConfig();
    $app_config_filename = $config["app_config_filename"];
    return importJson($app_config_filename)["app_id"];
}
