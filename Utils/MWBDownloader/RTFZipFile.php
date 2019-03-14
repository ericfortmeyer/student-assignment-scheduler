<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader;

use \ZipArchive;

final class RTFZipFile extends File
{
    protected const MIMETYPE = "application/zip";

    /**
     * A chainable implementation.
     *
     * This implementation also extracts the zip file.
     */
    public function downloadTo(string $directory): self
    {
        $this->destination = "$directory/{$this->filename()}";

        $this->download($this->destination);

        $this->setFileValidationFlags($this->destination);

        $this->validateAndExtract($this->destination);
        
        return $this;
    }
    
    /**
     * Extract the zip file.
     *
     * Keep this method private so that polymorphism can be enforced.
     *
     * @param string $filename
     * @return void
     */
    private function validateAndExtract(string $filename): void
    {
        /**
         * file validation needs to be handled here or this implementation
         * will attempt to extract a zip file that may not exist
         */
        $this->handleValidation();

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
            . basename($this->filename(), ".zip");
    }
}
