<?php

namespace StudentAssignmentScheduler\Functions\BackupAndRestore;

use PHPUnit\Framework\TestCase;

class ChangePathsInEnvFileTest extends TestCase
{
    protected function setUp(): void
    {
        $this->fake_env_filename = __DIR__ . "/../../../fakes/fake_env";
        $this->path_to_change = "/path/that/needs/to/change";
        $this->target_path = "/path/that/we/want/after/it/is/all/said/and/done";
        $first_key_value_pair = "test1={$this->path_to_change}/fake_filename.fake";
        $second_key_value_pair = "test2={$this->path_to_change}/another_fake_filename.fake";
        file_put_contents($this->fake_env_filename, join(PHP_EOL, [$first_key_value_pair, $second_key_value_pair]) . PHP_EOL);
    }

    public function testPathsInEnvFileIsReplacedAsExpected()
    {
        changePathsInEnvFile(
            $this->fake_env_filename,
            $this->target_path
        );

        $contents_of_env_file_after_string_replace = file_get_contents($this->fake_env_filename);

        $this->assertStringContainsString(
            $this->target_path,
            $contents_of_env_file_after_string_replace
        );

        $this->assertThat(
            $contents_of_env_file_after_string_replace,
            $this->logicalNot(
                $this->stringContains(
                    $this->path_to_change
                )
            )
        );
    }

    protected function tearDown(): void
    {
        file_exists($this->fake_env_filename) && unlink($this->fake_env_filename);
    }
}
