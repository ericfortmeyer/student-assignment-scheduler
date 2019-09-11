<?php

namespace StudentAssignmentScheduler\BackupAndRestore;

use StudentAssignmentScheduler\{
    Destination,
    Password
};

use PHPUnit\Framework\TestCase;

use \Ds\Vector;
use \ZipArchive;

class BackupConfigTest extends TestCase
{
    public function testReturnsZipArchiveIfBackupFilenameIsNotProvided()
    {
        $this->assertInstanceOf(
            ZipArchive::class,
            $zip = (new BackupConfig(
                new ListOfFiles(),
                new ListOfDirectories(),
                new Destination(__DIR__),
                new PasswordOption(new Password("some_fake_password"))
            ))->initZip()
        );
        $zip->close();
    }

    public function testFilesAreAddedFromNestedDirectories()
    {
        $tmp_dir = __DIR__ . "/../../tmp";
        $nested_dirname = "subdirectory";
        $nested_directory = "${tmp_dir}/${nested_dirname}";
        $fake_destination = "${tmp_dir}/fake_dest";
        @mkdir($nested_directory);
        @mkdir($fake_destination);
        $filenames = new Vector(
            [
                "fake1",
                "fake2",
                "fake3",
                "${nested_dirname}/fake4"
            ]
        );
        $this->filesToZip = $filenames->map(
            function (string $filename) use ($tmp_dir): string
            {
                return "${tmp_dir}/${filename}";
            }
        );
        $make_files = function (string $filename): void {
            touch($filename);
        };
        $this->filesToZip->map($make_files);
        $zip = new ZipArchive();
        $zip->open("php://temp", ZipArchive::CREATE);
        (new BackupConfig(
            new ListOfFiles(),
            new ListOfDirectories(new Vector([new Directory($tmp_dir)])),
            new Destination($fake_destination),
            new PasswordOption()
        ))->addDirectoriesRecursivelyToZip($zip);
        $this->assertSame(
            4,
            $zip->count()
        );
        $this->filesToZip->map(
            function (string $filename): void {
                @unlink($filename);
            }
        );
        @rmdir($nested_directory);
        @rmdir($fake_destination);
        @$zip->close();
    }
}
