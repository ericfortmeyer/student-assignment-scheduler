<?php declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/mock-extern-service/vendor/autoload.php";

!file_exists(__DIR__ . "/tmp") && mkdir(__DIR__ . "/tmp");

# generate a mock app config file
# otherwise tests will trigger CLI prompts
!file_exists(__DIR__ . "/../config/app_config.php")
    && system("sh " . __DIR__ . "/../build" . "/generate_app_config_stub.sh");
