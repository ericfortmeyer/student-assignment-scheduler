<?php

namespace StudentAssignmentScheduler\Utils\Functions;

use \Ds\Vector;

require_once "./Utils/Functions/includeFilesInDirectory.php";
require_once "./Utils/Functions/filenamesInDirectory.php";

$directories_in_app_root_dir = function (string $app_root_dir): array {
    return filenamesInDirectory($app_root_dir);
};
$includeFunctions = function (string $directory) {
    includeFilesInDirectory($directory . DIRECTORY_SEPARATOR . "Functions");
};
(new Vector($directories_in_app_root_dir))->map($includeFunctions);
