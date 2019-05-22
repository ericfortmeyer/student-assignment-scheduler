<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Classes;

use \ZipArchive;

use function StudentAssignmentScheduler\Functions\Filenaming\backupFileBasename;
use function StudentAssignmentScheduler\Functions\buildPath;

final class BackupConfig
{
    /**
     * @var ListOfFiles $files
     */
    private $files;

    /**
     * @var ListOfDirectories $directories
     */
    private $directories;

    /**
     * @var Destination $destination_of_backup_file
     */
    private $destination_of_backup_file;

    /**
     * @var PasswordOption $password_option
     */
    private $password_option;

    public function __construct(ListOfFiles $files, ListOfDirectories $directories, Destination $destination_of_backup_file, PasswordOption $password_option)
    {
        $this->files = $files;
        $this->directories = $directories;
        $this->destination_of_backup_file = $destination_of_backup_file;
        $this->password_option = $password_option;
    }

    public function addFilesToZip(ZipArchive $zip): void
    {
        $this->files->reduce(
            function ($carry, File $file) use ($zip) {
                $filename = (string) $file;
                $zip->addFile($filename, basename($filename));
                $this->password_option->select(
                    function () use ($zip, $filename) {
                        $zip->setEncryptionName(basename($filename), ZipArchive::EM_AES_256);
                    },
                    function () {
                        //no op
                    }
                );
            }
        );
    }

    public function initZip(string $backupFilenameForTesting = ""): \ZipArchive
    {
        $zip = new ZipArchive();
        $backupFilename = buildPath((string) $this->destination_of_backup_file, backupFileBasename($backupFilenameForTesting));
        $zip->open($backupFilename, ZipArchive::CREATE);
        $this->password_option->select(
            function ($password) use ($zip) {
                $zip->setPassword((string) $password);
            },
            function ($password) {
                //no op
            }
        );
        return $zip;
    }

    public function addDirectoriesRecursivelyToZip(ZipArchive $zip): void
    {
        $this->directories->reduce($this->addDirectoriesRecursively($zip));
    }

    private function addDirectoriesRecursively(ZipArchive $zip): \Closure
    {
        return function ($carry, Directory $directory) use ($zip): void {
            $directory->files()->reduce($this->addFilesRecursively($zip));
        };
    }

    private function addFilesRecursively(ZipArchive $zip): \Closure
    {
        return function ($carry, string $filename) use ($zip): void {
            if (is_dir($filename)) {
                $directory = new Directory($filename);
                $directory->files()->reduce($this->addFilesRecursively($zip));
            } else {
                $zip->addFile(
                    $filename,
                    buildPath(basename(dirname($filename)), basename($filename))
                );
                $this->password_option->select(
                    function () use ($zip, $filename) {
                        $zip->setEncryptionName(buildPath(basename(dirname($filename)), basename($filename)), ZipArchive::EM_AES_256);
                    },
                    function () {
                        //no op
                    }
                );
            }
        };
    }
}
