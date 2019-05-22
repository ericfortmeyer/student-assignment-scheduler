<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Classes;

use function StudentAssignmentScheduler\Functions\buildPath;

use \ZipArchive;

use \Ds\Set;

final class RestoreConfig
{
    /**
     * @var Destination $app_base_dir
     */
    private $app_base_dir;

    /**
     * @var Directory $tmp_dir
     */
    private $tmp_dir;

    /**
     * @var File|null $backup_file
     */
    private $backup_file;

    /**
     * @var PasswordOption $password_option
     */
    private $password_option;

    public function __construct(Destination $app_base_dir, Directory $tmp_dir, File $backup_file, PasswordOption $password_option)
    {
        $this->app_base_dir = $app_base_dir;
        $this->tmp_dir = $tmp_dir;
        $this->backup_file = $backup_file;
        $this->password_option = $password_option;
    }

    public function extractToTmpDir(ZipArchive $zip): void
    {
        $tmp_dir = (string) $this->tmp_dir;
        if ($zip->open((string) $this->backup_file) === true) {
            $this->password_option->select(
                function (Password $passwd) use ($zip, $tmp_dir) {
                    $zip->setPassword((string) $passwd);
                    if (!$zip->extractTo($tmp_dir)) {
                        throw new \Exception("Incorrect password");
                    }
                },
                function () use ($zip, $tmp_dir) {
                    $zip->extractTo($tmp_dir);
                }
            );
            $zip->close();
        }
    }

    public function removeTmpDir(): void
    {
        rmdir((string) $this->tmp_dir);
    }

    public function filesInTmpDir(): Set
    {
        return $this->tmp_dir->files();
    }

    public function newNameFromOldName(File $oldname): string
    {
        $filename = (string) $oldname;
        return buildPath((string) $this->app_base_dir, basename($filename));
    }
}
