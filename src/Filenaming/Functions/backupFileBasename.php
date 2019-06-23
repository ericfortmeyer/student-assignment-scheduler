<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
 declare(strict_types=1);

namespace StudentAssignmentScheduler\FileNaming\Functions;

use function StudentAssignmentScheduler\Querying\Functions\{
    getAppId,
    getAppVersion
};

function backupFileBasename(string $basename = ""): string
{
    /**
     * Data related to the backup file will be encoded in it's filename
     */
    $file_data = new class (getAppVersion(), getAppId(), (string) time()) {
        public $app_version;
        public $app_id;
        public $ctime;
        
        public function __construct(string $app_version, string $app_id, string $ctime)
        {
            $this->app_version = $app_version;
            $this->app_id = $app_id;
            $this->ctime = $ctime;
        }
    };
    
    $default_basename = \base64_encode(\json_encode($file_data));
    return $basename ? $basename : $default_basename ;
}
