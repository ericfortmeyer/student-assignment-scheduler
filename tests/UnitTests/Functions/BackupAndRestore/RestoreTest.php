<?php

namespace StudentAssignmentScheduler\Functions\BackupAndRestore;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\Classes\{
    RestoreConfig,
    PasswordOption,
    ListOfFiles,
    ListOfDirectories,
    File,
    Destination,
    Directory
};

use \Ds\Vector;

class RestoreTest extends TestCase
{
    protected function setUp(): void
    {
        $this->tmp_dir = __DIR__ . "/../../../tmp";
        $fakes_dir = __DIR__ . "/../../../fakes";
        $filenames = new Vector(
            [
                "fake1",
                "fake2",
                "fake3",
                "subdirectory/fake4"
            ]
        );

        $this->fake_backup_filename = "${fakes_dir}/fake_backup.zip";

        $this->tmp_dir_for_unzipped_backup = $this->tmp_dir . "/tmp_for_unzipped_backup";

        !file_exists($this->tmp_dir_for_unzipped_backup) && mkdir($this->tmp_dir_for_unzipped_backup);

        $this->expectedPathsToMovedFiles = $filenames->map(
            function (string $filename): string
            {
                return "{$this->tmp_dir}/${filename}";
            }
        );
    }

    public function testRestoreFunctionMovesFilesToExpectedDirectories()
    {
        $this->createFakeBackupFile($this->fake_backup_filename);
        
        restore(
            new RestoreConfig(
                new Destination($this->tmp_dir),
                new Directory($this->tmp_dir_for_unzipped_backup),
                new File($this->fake_backup_filename),
                new PasswordOption()
            )
        );

        $this->expectedPathsToMovedFiles->map(
            function (string $filename): void {
                $this->assertFileExists($filename);
            }
        );
    }

    private function createFakeBackupFile(string $filename): void
    {
        $zip = new \ZipArchive();

        $zip->open($this->fake_backup_filename, \ZipArchive::CREATE);

        $zip->addFromString("fake1", "this is a fake file");
        $zip->addFromString("fake2", "this is a fake file");
        $zip->addFromString("fake3", "this is a fake file");
        $zip->addFromString("subdirectory/fake4", "this is a fake file");
        $zip->close();
    }


    protected function tearDown(): void
    {
        $this->expectedPathsToMovedFiles->map(
            function (string $filename): void {
                file_exists($filename) && unlink($filename);
            }
        );

        file_exists($this->fake_backup_filename) && unlink($this->fake_backup_filename);
        file_exists($this->tmp_dir . "/subdirectory") && rmdir($this->tmp_dir . "/subdirectory");
    }
}
