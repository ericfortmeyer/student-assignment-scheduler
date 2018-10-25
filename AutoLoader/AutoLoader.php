<?php

namespace TalkSlipSender\AutoLoader;

class AutoLoader
{
    public static function loadClasses()
    {
        spl_autoload_register(function ($class) {
            $ext = ".php";
            $class = str_replace("\\", "/", $class);
            $parent_dir_of_project = realpath(__DIR__ . "/../../") . DIRECTORY_SEPARATOR;
            $path = $parent_dir_of_project . $class . $ext;
            if (file_exists($path)) {
                include_once($path);
            }
        }, false, false);
    }
}
