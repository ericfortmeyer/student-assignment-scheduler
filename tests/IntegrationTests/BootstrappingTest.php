<?php

namespace StudentAssignmentScheduler\Bootstrapping\Functions;

use PHPUnit\Framework\TestCase;

use function StudentAssignmentScheduler\Utils\Functions\filenamesInDirectory;

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
            $config_file = buildPath(__DIR__, "..", "fake_config", "config.php"),
            $path_config_file = buildPath(__DIR__, "..", "fake_config", "path_config.php")
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

    public function testDecryptedEmailPasswordIsAsExpected()
    {
        $given_nonce = \random_bytes(\SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $given_key = \sodium_crypto_secretbox_keygen();
        $encoded_nonce = \base64_encode($given_nonce);
        $encoded_key = \base64_encode($given_key);
        $given_plaintext_password = $expected_plaintext_password = "just a fake password";
        $encrypted_password = \sodium_crypto_secretbox(
            $given_plaintext_password,
            $given_nonce,
            $given_key
        );
        $encoded_password = \base64_encode($encrypted_password);
        \putenv("from_email_nonce=${encoded_nonce}");
        \putenv("from_email_key=${encoded_key}");
        \putenv("from_email_password=${encoded_password}");
        $this->assertSame(
            $expected_plaintext_password,
            decryptedPassword()
        );
        // cleanup
        \putenv("from_email_nonce");
        \putenv("from_email_key");
        \putenv("from_email_password");
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
