<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader;

use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testThrowsInvalidMimetypeException()
    {
        $file_info = new Fileinfo("fakeurl.com", "fake-checksum", 100, "text/bad-mimetype");
        $download_config = new Config\DownloadConfig([
            "apiUrl" => "https://apps.jw.org/GETPUBMEDIALINKS",
            "useragent" => "fake useragent",
            "apiOpts" => [
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_USERAGENT => "fake useragent"
            ],
            "apiQueryParams" => [
                "output" => "json",
                "fileformat" => "RTF",
                "pub" => "mwb",
                "alllangs" => 0,
                "langwritten" => "ASL"
            ],
            "language" => "en",
            "workbook_format" => "rtf",
            "workbook_download_destination" => __DIR__
        ]);

        try {
            new RtfZipFile($file_info, $download_config);
            $this->assertTrue(false);
        } catch (InvalidMimetypeException $e) {
            $this->assertTrue(true);
        }
    }
}
