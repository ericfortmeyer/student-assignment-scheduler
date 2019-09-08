<?php

namespace StudentAssignmentScheduler\FileNaming\Functions;

use PHPUnit\Framework\TestCase;

use function StudentAssignmentScheduler\Querying\Functions\{
    getAppId,
    getAppVersion
};

class BackupFileBasenameTest extends TestCase
{
    public function testComputedBackupFileBasenameIsAsExpectedWhenBasenameIsProvided()
    {
        $given_basename = "backup_file_basename_used_when_testing";
        $computedBackupFileBasename = backupFileBasename($given_basename);
        $this->assertSame(
            $given_basename,
            $computedBackupFileBasename
        );
    }

    public function testComputedBackupFileBasenameIsAsExpectedWhenBasenameIsNotProvided()
    {    $file_data = new class (getAppVersion(), getAppId(), (string) time()) {
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
        $expected_basename = \base64_encode(\json_encode($file_data));
        $computedBackupFileBasename = backupFileBasename();
        $this->assertSame(
            $expected_basename,
            $computedBackupFileBasename
        );
    }
}
