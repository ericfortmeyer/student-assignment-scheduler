<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader;

use PHPUnit\Framework\TestCase;
use StudentAssignmentScheduler\Year;
use \DateTimeImmutable;
use function StudentAssignmentScheduler\Utils\Functions\filenamesInDirectory;
use function StudentAssignmentScheduler\Downloading\Functions\download;


class DownloadingTest extends TestCase
{
    public function testWorkbookDownloadSuccessful()
    {
        // this test relies on dynamic information (time)
        // which will affect the filename of the workbook downloaded
        // therefore
        $workbook_format = "rtf";
        $language = "ASL";
        $path_to_workbook = __DIR__ . "/../tmp";

        $CurrentMonth = new Month((new DateTimeImmutable())->format("m"));
        $CurrentYear = new Year((new DateTimeImmutable())->format("Y"));
        $this->expected_workbook_filename = "$path_to_workbook/mwb_${language}_${CurrentYear}${CurrentMonth}.$workbook_format";
        $useragent = "StudentAssignmentScheduler TestRunner: e.fortmeyer01@gmail.com";

        $config = [
            "language" => $language,
            "workbook_format" => $workbook_format,
            "workbook_download_destination" => __DIR__ . "/../workbooks/$workbook_format",
            "apiUrl" => "https://apps.jw.org/GETPUBMEDIALINKS",
            "useragent" => $useragent,
            "apiOpts" => [
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_USERAGENT => $useragent
            ],
            "apiQueryParams" => [
                "output" => "json",
                "fileformat" => \strtoupper($workbook_format),
                "pub" => "mwb",
                "alllangs" => 0,
                "langwritten" => $language
            ]
        ];

        $this->assertFalse(
            \file_exists(
                $this->expected_workbook_filename
            )
        );

        download(
            $CurrentMonth,
            new Config\DownloadConfig(
                $config
            ),
            $path_to_workbook
        );

        $this->assertTrue(
            \file_exists(
                $this->expected_workbook_filename
            )
        );
    }

    protected function teardown(): void
    {
        (new \Ds\Vector(filenamesInDirectory($this->expected_workbook_filename)))->map(
            function (string $filename) {
                unlink("$this->expected_workbook_filename/$filename");
            }
        );

        rmdir($this->expected_workbook_filename);
    }
}
