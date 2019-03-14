<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader;

use function StudentAssignmentScheduler\Functions\Logging\logger;

define("FILESIZE", 6);
define("CHECKSUM", 8);

/**
 * Represents logic and information that a client can expect
 * from each instance of this class.
 */
abstract class File implements Downloadable, Validatable
{
    protected const MIMETYPE = "";

    protected $destination = "";
    
    /**
     * File validation flags can be accessed by clients of
     * instances of this class so that they will have the
     * option of handling file validation.
     *
     * @var bool $filesizeIsValid
     */
    public $filesizeIsValid = false;

    /**
     * @var bool $checksumPassed
     */
    public $checksumPassed = false;

    /**
     * @var Fileinfo $fileinfo
     */
    protected $fileinfo;

    /**
     * @var Config\DownloadConfig $config
     */
    protected $config;

    /**
     * @var Utils\Curl $downloader
     */
    protected $downloader;

    public function __construct(
        Fileinfo $fileinfo,
        Config\DownloadConfig $config,
        ?callable $downloader = null
    ) {
        $this->fileinfo = $fileinfo;

        if (static::MIMETYPE !== $this->fileinfo->mimetype) {
            throw new InvalidMimetypeException(
                static::class,
                static::MIMETYPE,
                $this->fileinfo->mimetype
            );
        }

        $this->config = $config;

        /**
         * Use a provided callable or Curl object
         */
        $this->downloader = $downloader ?? new Utils\Curl();
    }

    /**
     * A required method that must be implemented by instances
     * of this class.
     *
     * The return type is omitted for contravariance
     *
     * @param $directory
     */
    abstract public function downloadTo(string $directory);

    /**
     * An implementation for file validation handling
     *
     * Provide the full path to the file in case
     * error handling requires that it be deleted.
     *
     * @param string|null $full_path_of_file
     */
    public function handleValidation(?string $full_path_of_file = null): void
    {
        $errorHandling = $this->validationHandlingMap(
            $full_path_of_file ?? $this->destination
        );

        $this->filesizeIsValid || $errorHandling[FILESIZE]();
        $this->checksumPassed || $errorHandling[CHECKSUM]();
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
    protected function setFileValidationFlags(string $destination): void
    {
        $this->filesizeIsValid = $this->validateFilesize($destination);
        $this->checksumPassed = $this->verifyChecksum($destination);
    }

    protected function validateFilesize(string $filename): bool
    {
        return $this->fileinfo->filesize === filesize($filename);
    }

    protected function verifyChecksum(string $filename): bool
    {
        return $this->fileinfo->checksum === md5_file($filename);
    }

    protected function filesizeTuple(string $filename): array
    {
        return [
            // expected
            $this->fileinfo->filesize,
            // actual
            filesize($filename)
        ];
    }

    protected function checksumTuple(string $filename): array
    {
        return [
            // expected
            $this->fileinfo->checksum,
            // actual
            md5_file($filename)
        ];
    }
    
    protected function filename(): string
    {
        // last part of url
        $pattern = "/.*\/(.+)$/";
        preg_match($pattern, $this->fileinfo->url, $matches);
        
        return $matches[1];
    }

    protected function download(string $destination_filename): void
    {
        $fp = fopen($destination_filename, "w+");

        $curl_options = new Config\DownloadOptions([
            CURLOPT_URL => $this->fileinfo->url,
            CURLOPT_HEADER => false,
            CURLOPT_FILE => $fp,
            CURLOPT_USERAGENT => $this->config->useragent
        ]);

        $curl = $this->downloader;

        // perform the requested download
        $curl($curl_options);
        
        // important
        fclose($fp);
    }

    protected function validationHandlingMap(string $full_path_of_file): array
    {
        
        $logger = logger("invalid_file");
        
        $exceptionMessage = function (string $type) use ($full_path_of_file): string {
            return "The file $full_path_of_file has an invalid $type."
            . PHP_EOL . "The file may be corrupt or another error occured."
            . PHP_EOL . "Check the logs for more information.";
        };
        
        $logFunc = function (string $type, array $valueTuple) use ($logger, $full_path_of_file) {
            $url = $this->fileinfo->url;
            
            $context = function ($expected, $actual): array {
                return ["expected" => $expected, "actual" => $actual];
            };
            
            $logger->critical(
                "Invalid $type. The expected $type was {expected} but was {actual} instead."
                . PHP_EOL . "The file has been deleted."
                . PHP_EOL . "The url $url was used to download the file to $full_path_of_file",
                $context(...$valueTuple)
            );
        };
        
        /**
         * We want to throw an exception, delete the file, and log
         * the expected value, the actual value that caused the error,
         * the full path, and url used to download the file.
         */
        return [
            FILESIZE => function () use ($logFunc, $exceptionMessage, $full_path_of_file) {
                $tuple = $this->filesizeTuple($full_path_of_file);
                unlink($full_path_of_file);

                $logFunc("file size", $tuple);
                throw new InvalidFilesizeException($exceptionMessage);
            },
            CHECKSUM => function () use ($logFunc, $exceptionMessage, $full_path_of_file) {
                $tuple = $this->checksumTuple($full_path_of_file);
                unlink($full_path_of_file);

                $logFunc("checksum", $tuple);
                throw new InvalidChecksumException($exceptionMessage);
            }
        ];
    }
}
