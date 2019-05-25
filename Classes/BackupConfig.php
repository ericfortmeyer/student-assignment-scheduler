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
        $zip_ext = ".zip";
        $backupFilename = buildPath((string) $this->destination_of_backup_file, backupFileBasename($backupFilenameForTesting) . $zip_ext);
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
            $directory->files()->reduce($this->addFilesRecursively($zip, basename((string) $directory)));
        };
    }

    private function addFilesRecursively(ZipArchive $zip, string $directory): \Closure
    {
        return function ($carry, string $filename) use ($zip, $directory): void {
            if (is_dir($filename)) {
                $subdirectory = new Directory(buildPath($directory, basename($filename)));
                $path_to_subdirectory = (string) $subdirectory;
                $subdirectory->files()->reduce($this->addFilesRecursively($zip, $path_to_subdirectory));
            } else {
                $destination = buildPath($directory, basename($filename));
                $zip->addFile(
                    $filename,
                    $destination
                );
                $this->password_option->select(
                    function () use ($zip, $destination) {
                        $zip->setEncryptionName($destination, ZipArchive::EM_AES_256);
                    },
                    function () {
                        //no op
                    }
                );
            }
        };
    }
}
