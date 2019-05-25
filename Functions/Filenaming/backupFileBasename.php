<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Functions\Filenaming;

use function StudentAssignmentScheduler\Functions\{
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
