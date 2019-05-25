<?php declare(strict_types=1);

use function StudentAssignmentScheduler\FileRegistry\Functions\registerFile;
use function StudentAssignmentScheduler\Functions\hashOfFile;

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/mock-extern-service/vendor/autoload.php";

!file_exists(__DIR__ . "/tmp") && mkdir(__DIR__ . "/tmp");
!file_exists(__DIR__ . "/fakes") && mkdir(__DIR__ . "/fakes");

# generate a mock app config file
# otherwise tests will trigger CLI prompts
$app_config_filename = __DIR__ . "/../config/app_config.json";
!file_exists($app_config_filename)
    && (function (string $app_config_filename) {
        system("sh " . __DIR__ . "/../build" . "/generate_app_config_stub.sh");
        registerFile(
            hashOfFile($app_config_filename),
            $app_config_filename
        );
    })($app_config_filename);
