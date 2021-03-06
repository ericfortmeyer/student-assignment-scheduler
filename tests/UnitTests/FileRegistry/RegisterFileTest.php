<?php

namespace StudentAssignmentScheduler\FileRegistry\Functions;

use PHPUnit\Framework\TestCase;

class RegisterFileTest extends TestCase
{
    protected function setup(): void
    {
        // tests were breaking unexpectedly when the realpath function was not being used
        $this->path_to_test_files = realpath(__DIR__ . "/../../data");
        $registry_filename = sha1("test") . ".php";
        $this->test_registry = __DIR__ . "/../../mocks/${registry_filename}";
        generateRegistry([], $this->test_registry);
    }

    protected function teardown(): void
    {
        unlink($this->test_registry);
    }

    public function testCreatesRegistryIfNotExistsWhenAttemptingToRegisterFile()
    {
        $fake_registry = __DIR__ . "/../../mocks/ima_fake_registry.php";

        $file_key = "just_a_fake_file";
        $file_to_be_registered = "ima_fake_file.php";

        registerFile($file_key, $file_to_be_registered, $fake_registry);

        $this->assertFileExists($fake_registry);

        unlink($fake_registry);
    }

    /**
     * @covers ::StudentAssignmentScheduler\FileRegistry\Functions\validateFile
     */
    public function testRegistryHasHashedOfValueAsFilesKey()
    {
        $test_file = current($this->getTestFiles($this->path_to_test_files));
        $hash = sha1_file($test_file);

        registerFile($hash, $test_file, $this->test_registry);

        $registry = include $this->test_registry;

        $this->assertArrayHasKey(
            $hash,
            $registry
        );

        $this->assertSame(
            $test_file,
            $registry[$hash]
        );

        $this->assertSame(
            $hash,
            sha1_file($test_file)
        );

        $this->assertTrue(
            validateFile(
                $hash,
                $test_file,
                $this->test_registry
            )
        );
    }

    protected function getTestFiles(string $directory): array
    {
        return array_map(
            function (string $filename) use ($directory) {
                return "$directory/$filename";
            },
            array_diff(scandir($directory), [".", ".."])
        );
    }
}
