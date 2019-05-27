<?php

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
