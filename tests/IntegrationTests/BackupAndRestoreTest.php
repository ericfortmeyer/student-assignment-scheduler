<?php

namespace StudentAssignmentScheduler\BackupAndRestore\Functions;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\{
    BackupAndRestore\BackupConfig,
    BackupAndRestore\RestoreConfig,
    BackupAndRestore\Directory,
    BackupAndRestore\ListOfDirectories,
    BackupAndRestore\ListOfFiles,
    BackupAndRestore\PasswordOption,
    BackupAndRestore\File,
    Exception\IncorrectPasswordException,
    Destination,
    Password
};

use \Ds\Vector;
use \ZipArchive;

class BackupAndRestoreTest extends TestCase
{
    protected function setUp(): void
    {
        $this->tmp_dir = __DIR__ . "/../tmp";
        $this->fakes_dir = __DIR__ . "/../fakes";
        @mkdir($this->tmp_dir);
        @mkdir($this->fakes_dir);
        $this->fake_config_dir = "{$this->fakes_dir}/config";
        $this->fake_data_dir = "{$this->fakes_dir}/data";
        $this->tmp_dir_for_unzipped_backup = $this->tmp_dir . "/tmp_for_unzipped_backup";
        $this->fake_backup_basename = "test";
        $this->fake_backup_filename = "{$this->fake_backup_basename}.zip";
        @mkdir($this->fake_config_dir);
        @mkdir($this->fake_data_dir);
        @mkdir($this->tmp_dir_for_unzipped_backup);
        $this->fake_config_files = [
            "fake_config.php",
            "fake_path_config.php",
            "fake_app_config.json"
        ];
        $this->fake_data_files = [
            "fake_data.json",
            "2019_fake_data.json"
        ];
        $make_files = function (string $destination): \Closure {
            return function (string $basename) use ($destination): void {
                touch("$destination/$basename");
            };
        };
        array_map(
            $make_files($this->fake_config_dir),
            $this->fake_config_files
        );
        array_map(
            $make_files($this->fake_data_dir),
            $this->fake_data_files
        );
    }

    protected function tearDown(): void
    {
        $remove_files = function (string $destination): \Closure {
            return function (string $basename) use ($destination): void {
                $fullpath = "${destination}/${basename}";
                @unlink($fullpath);
            };
        };
        array_map(
            $remove_files($this->fake_config_dir),
            $this->fake_config_files
        );
        array_map(
            $remove_files($this->fake_data_dir),
            $this->fake_data_files
        );
        @rmdir($this->fake_config_dir);
        @rmdir($this->fake_data_dir);
        @rmdir($this->tmp_dir_for_unzipped_backup);
    }

    public function testBackupWithPassword()
    {
        $given_password = "some_fake_password";
        $this->backupFunctionCausesExpectedFilesToBeWrittenToTargetDirectory(new Password($given_password));
    }

    public function testBackupWithoutPassword()
    {
        $this->backupFunctionCausesExpectedFilesToBeWrittenToTargetDirectory(null);
    }

    public function testThrowsIncorrectPasswordExceptionWhenGivenWrongPassword()
    {
        $correct_password = new Password("i am the correct password");
        $wrong_password = new Password("i am the wrong password");
        try {
            $this->fileRestoreCausesExpectedFilesToBeMovedToExpectedFolder($correct_password, $wrong_password);
            $this->assertTrue(false); // test failed
        } catch (\Exception $e) {
            $this->assertTrue(true); // test passed
        }
    }

    private function backupFunctionCausesExpectedFilesToBeWrittenToTargetDirectory(?Password $password = null)
    {
        $fake_env_filename = "{$this->fakes_dir}/.test_env";
        @touch($fake_env_filename);
        $resulting_zip_filename = "{$this->tmp_dir}/{$this->fake_backup_filename}";
        $list_of_files = new ListOfFiles();
        $list_of_directories = new ListOfDirectories();
        $list_of_files->add($FileObj = new File($fake_env_filename));
        $list_of_directories->add(new Directory($this->fake_config_dir));
        $list_of_directories->add(new Directory($this->fake_data_dir));
        backup(
            new BackupConfig(
                $list_of_files,
                $list_of_directories,
                new Destination($this->tmp_dir),
                new PasswordOption($password)
            ),
            $this->fake_backup_basename
        );
        $this->assertSame(
            $fake_env_filename,
            (string) $FileObj
        );
        $this->assertFileExists(
            $resulting_zip_filename
        );
        @unlink($resulting_zip_filename);
        @unlink($fake_env_filename);
    }

    public function testRestoreWithPassword()
    {
        $this->fileRestoreCausesExpectedFilesToBeMovedToExpectedFolder(new Password("some_fake_password"));
    }

    public function testRestoreWithoutPassword()
    {
        $this->fileRestoreCausesExpectedFilesToBeMovedToExpectedFolder(null);
    }

    private function fileRestoreCausesExpectedFilesToBeMovedToExpectedFolder(?Password $password, ?Password $wrong_password_for_restore = null)
    {
        $restore_destination = __DIR__ . "/dest";
        $source = __DIR__ . "/source";
        $tmp = __DIR__ . "/tmp";
        $sub_dirname = "subdirectory";
        $sub_dir_to_remove = "${restore_destination}/${sub_dirname}";

        @mkdir($restore_destination);
        @mkdir($source);
        @mkdir($tmp);
        $fake_backup_file_to_restore = "${source}/restore_me.zip";
        $files = new Vector([
            "fake1",
            "fake2",
            "fake3",
            "${sub_dirname}/fake4"
        ]);
        $zip = new ZipArchive();
        $zip->open($fake_backup_file_to_restore, ZipArchive::CREATE);
        if ($password !== null) {
            $zip->setPassword((string) $password);
        }
        $addFileFromString = function (string $filename) use ($zip, $password) {
            $zip->addFromString($filename, "this is a fake file");
            if ($password !== null) {
                $zip->setEncryptionName($filename, ZipArchive::EM_AES_256);
            }
        };
        $files->map($addFileFromString);
        $zip->close();
        $restore_config = new RestoreConfig(
            new Destination($restore_destination),
            new Directory($tmp),
            new File($fake_backup_file_to_restore),
            new PasswordOption($wrong_password_for_restore ?? $password)
        );
        restore($restore_config);
        $checkFilesExist = function (string $filename) use ($restore_destination) {
            $this->assertFileExists(
                "${restore_destination}/${filename}"
            );
        };
        $removeFiles = function (string $filename) use ($restore_destination) {
            @unlink("${restore_destination}/${filename}");
        };
        $files->map($checkFilesExist);
        $files->map($removeFiles);
        unlink($fake_backup_file_to_restore);
        rmdir($sub_dir_to_remove);
        rmdir($restore_destination);
        rmdir($source);
    }

    public function testPathsInEnvFileIsReplacedAsExpected()
    {
        $path_to_change = "/path/that/needs/to/change";
        $target_path = "/path/that/we/want/after/it/is/all/said/and/done";
        $fake_env_filename = __DIR__ . "/../fakes/fake_env";
        $first_key_value_pair = "random_key=value_that_should_not_change";
        $second_key_value_pair = "test1={$path_to_change}/fake_filename.fake";
        $third_key_value_pair = "test2={$path_to_change}/another_fake_filename.fake";
        file_put_contents($fake_env_filename, join(PHP_EOL, [$first_key_value_pair, $second_key_value_pair]) . PHP_EOL);
        changePathsInEnvFile(
            $fake_env_filename,
            $path_to_change,
            $target_path
        );
        $contents_of_env_file_after_string_replace = file_get_contents($fake_env_filename);
        $this->assertStringContainsString(
            $target_path,
            $contents_of_env_file_after_string_replace
        );
        $this->assertThat(
            $contents_of_env_file_after_string_replace,
            $this->logicalNot(
                $this->stringContains(
                    $path_to_change
                )
            )
        );
        @unlink($fake_env_filename);
    }
}
