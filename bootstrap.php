<?php

namespace StudentAssignmentScheduler\Functions\Bootstrapping;

use function StudentAssignmentScheduler\Functions\makeRequiredDirectories;

/**
 * Compatibility checking,
 * Install required composer packages,
 * Include autoloader,
 * Load configurations
 * 
 * @return array [config[], path_config[], string config_filename]
 */
return (function (): array {
    ///////////////////////
    //
    //   COMPATIBILITY
    //     CHECKING
    //
    //////////////////////

    $php_version_is_not_compatible = PHP_VERSION_ID < 70200;

    define('REQUIRED_MODULES', [
        "ds",
        "zip",
        "mbstring",
        "ast",
        "xml"
    ]);
    
    $required_modules_that_are_not_installed = [];
    
    foreach (REQUIRED_MODULES as $required_module) {
        $required_module_is_not_installed = !extension_loaded($required_module);
        $addToList = function (string $required_module) use (&$required_modules_that_are_not_installed) {
            $required_modules_that_are_not_installed[] = $required_module;
        };
    
        if ($required_module_is_not_installed) {
            $addToList($required_module);
        }
    }
    
    $required_modules_are_not_installed = !empty($required_modules_that_are_not_installed);
    
    if ($php_version_is_not_compatible) {
        exit(
            PHP_EOL. ": (" . PHP_EOL
                . "Sorry.  This software requires PHP Version 7.2 or greater." . PHP_EOL . PHP_EOL
        );
    }
    
    if ($required_modules_are_not_installed) {
        $list_of_modules_needed = join(", ", $required_modules_that_are_not_installed);
        exit(
            PHP_EOL . ": (" . PHP_EOL
                . "Sorry. It looks like there are a few PHP modules that need to be installed"
                . " for this software to function.  Please install ${list_of_modules_needed}." . PHP_EOL . PHP_EOL
        );
    }
    
    ///////////////////////
    //
    //   BOOTSTRAPPING
    //
    //////////////////////
    
    $actions = new \Ds\PriorityQueue();
    
    
    // install required composer packages
    $actions->push(
        function () {
            require "./Functions/Bootstrapping/runInstallScriptIfRequired.php";
            require "./Functions/Bootstrapping/buildPath.php";
            runInstallScriptIfRequired(
                buildPath(__DIR__, "vendor"),
                buildPath(__DIR__, "scripts", "install.sh")
            );
        },
        10
    );
    
    // require the autoloader
    $actions->push(
        function () {
            require file_exists("autoload.php")
                ? "autoload.php"
                : buildPath("vendor", "autoload.php");
        },
        9
    );
    
    // load configurations
    $actions->push(
        function (): array {
            $config_dir = file_exists("config")
                ? "config"
                : buildPath("vendor", "ericfortmeyer", "student-assignment-scheduler", "config");
            [$config, $path_config] = loadConfigurationFiles(
                new \Ds\Vector([
                    $config_file = buildPath(__DIR__, $config_dir, "config.php"),
                    buildPath(__DIR__, $config_dir, "path_config.php")
                ])
            )->toArray();
            makeRequiredDirectories($config["make_these_directories"]);
    
            return [$config, $path_config, $config_file];
        },
        7
    );
    
    while ($actions->count() > 1) {
        $func = $actions->pop();
        $func();
    }
    $final_action = $actions->pop();
    $array_of_config_files = $final_action();

    return $array_of_config_files;
})();
