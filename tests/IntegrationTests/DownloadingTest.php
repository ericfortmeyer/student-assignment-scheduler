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
        $options = $this->configOptions();
        $config = $this->getConfig($options);

        $this->assertFalse(
            \file_exists(
                $options->expected_workbook_filename
            )
        );

        download(
            $options->CurrentMonth,
            new Config\DownloadConfig($config),
            $options->path_to_workbook
        );

        $this->assertTrue(
            \file_exists(
                $options->expected_workbook_filename
            )
        );
        (new \Ds\Vector(filenamesInDirectory($options->expected_workbook_filename)))->map(
            function (string $filename) use ($options) {
                unlink("{$options->expected_workbook_filename}/${filename}");
            }
        );
        rmdir($options->expected_workbook_filename);
    }

    protected function configOptions(?string $url = null): object
    {
        return new class($url) {
            // this test relies on dynamic information (time)
            // which will affect the filename of the workbook downloaded
            // therefore
            public $workbook_format = "rtf";
            public $language = "ASL";
            public $path_to_workbook = __DIR__ . "/../tmp";
            public $url = "";
            public $useragent = "StudentAssignmentScheduler TestRunner: e.fortmeyer01@gmail.com";
            /**
             * @var Month
             */
            public $CurrentMonth;

            /**
             * @var Year
             */
            public $CurrentYear;
            public $expected_workbook_filename = "";

            public function __construct(?string $url = null)
            {
                $this->url = $url ?? "https://apps.jw.org/GETPUBMEDIALINKS";
                $this->CurrentMonth = new Month((new DateTimeImmutable())->format("m"));
                $this->CurrentYear = new Year((new DateTimeImmutable())->format("Y"));
                $this->expected_workbook_filename = "{$this->path_to_workbook}/mwb_{$this->language}_{$this->CurrentYear}{$this->CurrentMonth}.{$this->workbook_format}";
            }
        };
    }

    protected function getConfig(object $options): array
    {
        return [
            "language" => $options->language,
            "workbook_format" => $options->workbook_format,
            "workbook_download_destination" => __DIR__ . "/../workbooks/{$options->workbook_format}",
            "apiUrl" => $options->url,
            "useragent" => $options->useragent,
            "apiOpts" => [
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_USERAGENT => $options->useragent
            ],
            "apiQueryParams" => [
                "output" => "json",
                "fileformat" => \strtoupper($options->workbook_format),
                "pub" => "mwb",
                "alllangs" => 0,
                "langwritten" => $options->language
            ]
        ];
    }

    public function testThrowsInvalidUrlException()
    {
        $options = $this->configOptions("https://badurl.com/fake-path");
        $config = $this->getConfig($options);
        try {
            download(
                $options->CurrentMonth,
                new Config\DownloadConfig($config),
                $options->path_to_workbook
            );
            $this->assertTrue(false);
        } catch (Utils\InvalidUrlException $e) {
            $this->assertTrue(true);
        }
    }
}
