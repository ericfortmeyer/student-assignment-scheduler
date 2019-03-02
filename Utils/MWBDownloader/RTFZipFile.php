<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader;

use StudentAssignmentScheduler\Utils\MWBDownloader\Config\DownloadOptions;
use \ZipArchive;

define("FILESIZE", 6);
define("CHECKSUM", 8);

class RTFZipFile
{
    private $fileinfo;

    /**
     * @var Config\DownloadConfig $config
     */
    private $config;

    public $filesizeIsValid = false;
    public $checksumPassed = false;
    
    public function __construct(
        Fileinfo $fileinfo,
        Config\DownloadConfig $config
    ) {
        $this->fileinfo = $fileinfo;
        $this->config = $config;
    }
    
    public function __get($value)
    {
        return $this->fileinfo->$value;
    }

    private function validateFilesize(string $filename): bool
    {
        return $this->fileinfo->filesize === filesize($filename);
    }

    private function verifyChecksum(string $filename): bool
    {
        return $this->fileinfo->checksum === md5_file($filename);
    }

    private function filename(): string
    {
        // last part of url
        $pattern = "/.*\/(.+)$/";
        preg_match($pattern, $this->fileinfo->url, $matches);
        
        return $matches[1];
    }

    public function downloadToDirectory(string $directory): self
    {
        $destination = "$directory/{$this->filename()}";

        $this->download($destination);

        $this->setFileValidationFlags($destination);

        $this->extract($destination);

        return $this;
    }


    /**
     * Option to handle file validation internally or allow another class to handle it
     *
     * The results of file validation are set as properties
     * to allow file validation handling by the application
     * if desired
     *
     * @param string $destination
     * @return void
     */
    private function setFileValidationFlags(string $destination): void
    {
        $this->filesizeIsValid = $this->validateFilesize($destination);
        $this->checksumPassed = $this->verifyChecksum($destination);
    }
    
    private function download(string $destination_filename): void
    {
        $fp = fopen($destination_filename, "w+");
        
        $options = new DownloadOptions([
            CURLOPT_URL => $this->fileinfo->url,
            CURLOPT_HEADER => false,
            CURLOPT_FILE => $fp,
            CURLOPT_USERAGENT => $this->config->useragent
        ]);

        $curl = new Utils\Curl();

        $curl($options);
        
        // important
        fclose($fp);
    }
    
    /**
     * Define file validation handled by this class.
     *
     *
     */
    public function handleFileValidation(): void
    {
        $errorHandling = $this->validationHandlingMap();

        $errorHandling[FILESIZE]($this->filesizeIsValid);
        $errorHandling[CHECKSUM]($this->checksumPassed);
    }

    public function extract(string $filename): void
    {
        $zip = new ZipArchive();
        $destination_directory = $this->destinationDirFromFilename($filename);

        if ($zip->open($filename) === true) {
            $this
                ->extractZipFileTo($zip, $destination_directory)
                ->deleteZipFile($filename);
        }
    }

    private function extractZipFileTo(ZipArchive $zip, string $destination_directory): self
    {
        $zip->extractTo($destination_directory);
        $zip->close();

        return $this;
    }

    private function deleteZipFile(string $filename): void
    {
        unlink($filename);
    }

    private function destinationDirFromFilename(string $filename): string
    {
        return dirname($filename)
            . DIRECTORY_SEPARATOR
            . $this->filename();
    }

    private function validationHandlingMap(): array
    {
        return [
            FILESIZE => function (bool $isValid) {
            },
            CHECKSUM => function (bool $passed) {
            }
        ];
    }
}
