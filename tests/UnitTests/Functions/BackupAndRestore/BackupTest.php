<?php

namespace StudentAssignmentScheduler\Functions\BackupAndRestore;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\Classes\{
    BackupConfig,
    ListOfFiles,
    ListOfDirectories,
    File,
    Destination,
    Directory,
    PasswordOption
};

class BackupTest extends TestCase
{
    protected function setUp(): void
    {
        $fakes_dir = __DIR__ . "/../../../fakes";
        $this->fake_config_dir = "${fakes_dir}/config";
        $this->fake_data_dir = "${fakes_dir}/data";

        $this->fake_env_file = "${fakes_dir}/.test_env";

        !file_exists($this->fake_env_file) && touch ($this->fake_env_file);
        !file_exists($this->fake_config_dir) && mkdir($this->fake_config_dir);
        !file_exists($this->fake_data_dir) && mkdir($this->fake_data_dir);

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
        $this->tmp_dir = __DIR__ . "/../../../tmp";
        $this->fake_backup_basename = "test";
        $this->fake_backup_filename = $this->fake_backup_basename . ".zip";

        $this->resulting_zip_filename = $this->tmp_dir . DIRECTORY_SEPARATOR . $this->fake_backup_filename;
    }
    
    public function testBackupFunctionCausesExpectedFilesToBeWrittenToTargetDirectory()
    {
        $fakes_dir = __DIR__ . "/../../../fakes";
        $this->assertFileExists($this->tmp_dir);
        $this->assertFileExists($fakes_dir);

        $list_of_files = new ListOfFiles();
        $list_of_directories = new ListOfDirectories();

        $list_of_files->add(new File("${fakes_dir}/.test_env"));
        $list_of_directories->add(new Directory("${fakes_dir}/config"));
        $list_of_directories->add(new Directory("${fakes_dir}/data"));

        backup(
            new BackupConfig(
                $list_of_files,
                $list_of_directories,
                new Destination($this->tmp_dir),
                new PasswordOption(null)
            ),
            $this->fake_backup_basename
        );


        $this->assertFileExists(
            $this->resulting_zip_filename
        );
    }

    protected function tearDown(): void
    {
        $remove_files = function (string $destination): \Closure {
            return function (string $basename) use ($destination): void {
                $fullpath = "${destination}/${basename}";
                file_exists($fullpath) && unlink($fullpath);
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
        file_exists($this->fake_env_file) && unlink($this->fake_env_file);
        file_exists($this->fake_config_dir) && rmdir($this->fake_config_dir);
        file_exists($this->fake_data_dir) && rmdir($this->fake_data_dir);
        file_exists($this->resulting_zip_filename) && unlink($this->resulting_zip_filename);
    }
}
