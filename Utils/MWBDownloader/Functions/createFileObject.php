<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Functions;

use StudentAssignmentScheduler\Utils\MWBDownloader\{
    Fileinfo,
    RTFZipFile,
    File,
    Config\DownloadConfig
};

function createFileObject(object $payload, DownloadConfig $config): File
{
    $FileData = extractFileDataFromPayload($payload, $config);
    
    $fileinfo = new Fileinfo(
        url($FileData),
        checksum($FileData),
        _filesize($FileData),
        mimetype($FileData)
    );

    return new RTFZipFile($fileinfo, $config);
}

function extractFileDataFromPayload(object $payload, DownloadConfig $config): object
{
    return current(
        $payload
            ->files
            ->{$config->language}
            ->{strtoupper($config->workbook_format->toString())}
    );
}

function url(object $FileData): string
{
    return $FileData->file->url;
}

function checksum(object $FileData): string
{
    return $FileData->file->checksum;
}

function _filesize(object $FileData): int
{
    return $FileData->filesize;
}

function mimetype(object $FileData): string
{
    return $FileData->mimetype;
}
