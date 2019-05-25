<?php

namespace StudentAssignmentScheduler\Functions;

function getAppId(): string
{
    $config = getConfig();
    $app_config_filename = $config["app_config_filename"];
    return importJson($app_config_filename)["app_id"];
}
