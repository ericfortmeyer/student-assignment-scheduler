<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Config;

use PHPUnit\Framework\TestCase;

class FiletypeTest extends TestCase
{
    public function testThrowsInvalidFiletypeException()
    {
        $invalid_filetypes = [
            "php",
            "html",
            "json"
        ];
        array_map(
            function (string $filetype) {
                try {
                    new Filetype($filetype);
                    $this->assertTrue(false);
                } catch (InvalidFiletypeException $e) {
                    $this->assertTrue(true);
                }
            },
            $invalid_filetypes
        );
    }
}
