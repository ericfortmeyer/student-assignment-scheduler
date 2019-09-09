<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Config;

use PHPUnit\Framework\TestCase;

class ApiCurlOptionsTest extends TestCase
{
    public function testThrowsInvalidConfigurationExceptionIfRequiredKeysAreNotPresent()
    {
        // REQUIRED_KEYS = [
        //     CURLOPT_HEADER,
        //     CURLOPT_RETURNTRANSFER,
        //     CURLOPT_USERAGENT
        // ];
        $arrays_missing_required_keys = [
            [
                CURLOPT_HEADER,
                CURLOPT_RETURNTRANSFER
            ],
            [
                CURLOPT_HEADER,
                CURLOPT_USERAGENT
            ],
            [
                CURLOPT_RETURNTRANSFER,
                CURLOPT_USERAGENT
            ]
        ];
        $url = new ApiUrl("https://example.com/path");
        array_map(
            function (array $array_missing_required_key) use ($url) {
                try {
                    new ApiCurlOptions($array_missing_required_key, $url);
                    $this->assertTrue(false);
                } catch (InvalidConfigurationException $e) {
                    $this->assertTrue(true);
                }
            },
            $arrays_missing_required_keys
        );
    }
}
