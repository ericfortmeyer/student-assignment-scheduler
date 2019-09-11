<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Config;

use PHPUnit\Framework\TestCase;

class DownloadCurlOptionsTest extends TestCase
{
    public function testThrowsInvalidConfigurationExceptionIfRequiredKeysAreNotPresent()
    {
        // REQUIRED_KEYS = [
        //     CURLOPT_URL,
        //     CURLOPT_FILE,
        //     CURLOPT_USERAGENT,
        //     CURLOPT_HEADER,
        // ];
        $arrays_missing_required_keys = [
            [
                CURLOPT_FILE,
                CURLOPT_USERAGENT,
                CURLOPT_HEADER
            ],
            [
                CURLOPT_URL,
                CURLOPT_USERAGENT,
                CURLOPT_HEADER
            ],
            [
                CURLOPT_URL,
                CURLOPT_FILE,
                CURLOPT_HEADER
            ],
            [
                CURLOPT_URL,
                CURLOPT_FILE,
                CURLOPT_USERAGENT
            ]
        ];
        $url = new ApiUrl("https://example.com/path");
        array_map(
            function (array $array_missing_required_key) use ($url) {
                try {
                    new DownloadCurlOptions($array_missing_required_key, $url);
                    $this->assertTrue(false);
                } catch (InvalidConfigurationException $e) {
                    $this->assertTrue(true);
                }
            },
            $arrays_missing_required_keys
        );
    }
}
