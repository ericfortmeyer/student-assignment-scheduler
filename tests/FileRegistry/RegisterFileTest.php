<?php

namespace TalkSlipSender\FileRegistry\Functions;

use PHPUnit\Framework\TestCase;

class RegisterFileTest extends TestCase
{
    protected function setup()
    {
        $this->path_to_test_files = __DIR__ . "/../data";
        $registry_filename = sha1("test") . ".php";
        $this->test_registry = __DIR__ . "/../mocks/${registry_filename}";
        generateRegistry([], $this->test_registry);
    }

    protected function tearDown()
    {
        unlink($this->test_registry);
        unset($this->test_registry);
    }

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
