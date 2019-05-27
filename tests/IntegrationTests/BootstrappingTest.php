<?php

namespace StudentAssignmentScheduler\Bootstrapping\Functions;

use PHPUnit\Framework\TestCase;

use function StudentAssignmentScheduler\Functions\filenamesInDirectory;

use \Ds\Vector;

class BootstrappingTest extends TestCase
{
    protected function setup(): void
    {
        $tmp_dir = buildPath(__DIR__, "..", "tmp");
        $this->mock_vendor_dir = buildPath($tmp_dir, "vendor");
        $this->location_of_mock_installation_script = buildPath(
            __DIR__,
            "..",
            "mocks",
            "scripts",
            "install.sh"
        );

        $this->mock_env_file = buildPath(__DIR__, "..", "tmp", ".env");
        $this->mock_secrets_directory = buildPath($tmp_dir, "mock_secrets");
    }

    public function testVendorDirectoryIsCreatedIfItDoesNotExist()
    {
        $this->assertFalse(
            \file_exists($this->mock_vendor_dir)
        );

        runInstallScriptIfRequired(
            $this->mock_vendor_dir,
            $this->location_of_mock_installation_script
        );

        $this->assertTrue(
            \file_exists($this->mock_vendor_dir)
        );
    }

    public function testDataFromConfigFilesIsAsExpected()
    {
        $config_files = new Vector([
            $config_file = buildPath(__DIR__, "..", "mocks", "config", "config.php"),
            $path_config_file = buildPath(__DIR__, "..", "mocks", "config", "path_config.php")
        ]);

        [
            $data_from_config_file,
            $data_from_path_config_file
        ] = loadConfigurationFiles($config_files);

        $expected_data_from_config_file = ["fake_data" => [1, 2, 3]];
        $expected_data_from_path_config_file = ["path_to_nowhere" => "/path/to/nowhere"];

        $this->assertSame(
            $expected_data_from_config_file,
            $data_from_config_file
        );

        $this->assertSame(
            $expected_data_from_path_config_file,
            $data_from_path_config_file
        );
    }

    public function testSecretKeysAreSetup()
    {
        $this->assertFalse(
            \file_exists($this->mock_secrets_directory)
        );

        $this->assertFalse(
            \file_exists($this->mock_env_file)
        );


        setupKeys(
            $this->mock_secrets_directory,
            dirname($this->mock_env_file)
        );

        $secretsDirectoryContainsFiles = $this->doesSecretsDirectoryContainFiles($this->mock_secrets_directory);

        $this->assertTrue(
            \file_exists($this->mock_secrets_directory)
        );
        
        $this->assertTrue($secretsDirectoryContainsFiles);

        $this->assertTrue(
            \file_exists(
                $this->mock_env_file
            )
        );
    }

    protected function doesSecretsDirectoryContainFiles(string $secrets_dir): bool
    {
        return !(new Vector(filenamesInDirectory($secrets_dir)))->isEmpty();
    }

    protected function teardown(): void
    {
        \file_exists($this->mock_vendor_dir)
            && \rmdir($this->mock_vendor_dir);

        \file_exists($this->mock_env_file)
            && \unlink($this->mock_env_file);

        \file_exists($this->mock_secrets_directory)
            && (new Vector(filenamesInDirectory($this->mock_secrets_directory)))->apply(
                function (string $basename) {
                    $filename = buildPath($this->mock_secrets_directory, $basename);
                    \unlink($filename);
                }
            );

        \file_exists($this->mock_secrets_directory)
            && \rmdir($this->mock_secrets_directory);
    }
}
