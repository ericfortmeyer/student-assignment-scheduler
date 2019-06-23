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

final class Fileinfo
{
    private $url;
    private $checksum;
    private $filesize;
    private $mimetype;

    public function __construct(
        string $url,
        string $checksum,
        int $filesize,
        string $mimetype
    ) {
        $this->url = $url;
        $this->checksum = $checksum;
        $this->filesize = $filesize;
        $this->mimetype = $mimetype;
    }

    public function __get($value)
    {
        return $this->$value;
    }
}
