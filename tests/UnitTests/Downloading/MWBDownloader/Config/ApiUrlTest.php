<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Config;

use PHPUnit\Framework\TestCase;

class ApiUrlTest extends TestCase
{
    public function testThrowsInvalidConfigurationExceptionIfUrlIsInvalid()
    {
        $bad_urls = [
            "bad url",
            "http://bad",
            "https://bad."
        ];
        array_map(
            function (string $bad_url) {
                try {
                    new ApiUrl($bad_url);
                    $this->assertTrue(false); // test failed
                } catch (InvalidConfigurationException $e) {
                    $this->assertTrue(true); // test passed
                }
            },
            $bad_urls
        );
    }
}
