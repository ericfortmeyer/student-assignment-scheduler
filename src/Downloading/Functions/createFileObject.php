<?php

namespace StudentAssignmentScheduler\Downloading\Functions;

use StudentAssignmentScheduler\Downloading\MWBDownloader\{
    Fileinfo,
    RTFZipFile,
    File,
    Config\DownloadConfig
};

function createFileObject(object $payload, DownloadConfig $config): File
{
    $FileData = _extractFileDataFromPayload($payload, $config);
    
    $fileinfo = new Fileinfo(
        _url($FileData),
        _checksum($FileData),
        _filesize($FileData),
        _mimetype($FileData)
    );

    return new RTFZipFile($fileinfo, $config);
}

function _extractFileDataFromPayload(object $payload, DownloadConfig $config): object
{
    return current(
        $payload
            ->files
            ->{$config->language}
            ->{strtoupper($config->workbook_format->toString())}
    );
}

function _url(object $FileData): string
{
    return $FileData->file->url;
}

function _checksum(object $FileData): string
{
    return $FileData->file->checksum;
}

function _filesize(object $FileData): int
{
    return $FileData->filesize;
}

function _mimetype(object $FileData): string
{
    return $FileData->mimetype;
}
