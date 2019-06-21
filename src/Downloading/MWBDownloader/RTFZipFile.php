<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Downloading\MWBDownloader;

use \ZipArchive;

final class RTFZipFile extends File
{
    protected const MIMETYPE = "application/zip";

    /**
     * A chainable implementation.
     *
     * Extend the base class's implementation so that
     * we can extract the zip file.
     */
    public function downloadTo(string $directory): self
    {
        parent::downloadTo($directory);

        $this->extract($this->destination);
        
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
    private function extract(string $filename): void
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
            . basename($this->filename(), ".zip");
    }

    /**
     * The zip extension is removed before checking
     * if file exists.
     *
     * @param string $destination_filename
     * @return bool
     */
    protected function fileDoesNotExist(string $destination_filename): bool
    {
        return !file_exists(
            $this->destinationDirFromFilename($destination_filename)
        );
    }
}
