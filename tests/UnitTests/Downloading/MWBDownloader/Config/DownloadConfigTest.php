<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Config;

use PHPUnit\Framework\TestCase;

class DownloadConfigTest extends TestCase
{
    public function testThrowsInvalidConfigurationException()
    {
        // REQUIRED = [
        //     "apiUrl",
        //     "apiOpts",
        //     "apiQueryParams",
        //     "language",
        //     "workbook_format",
        //     "workbook_download_destination",
        //     "useragent"
        // ];

        try {
            new DownloadConfig([
                "apiUrl"
            ]);
            $this->assertTrue(false);
        } catch (InvalidConfigurationException $e) {
            $this->assertTrue(true);
        }
    }
}
