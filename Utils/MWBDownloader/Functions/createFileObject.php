<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Functions;

use StudentAssignmentScheduler\Utils\MWBDownloader\Config\DownloadConfig;
use StudentAssignmentScheduler\Utils\MWBDownloader\Fileinfo;
use StudentAssignmentScheduler\Utils\MWBDownloader\RTFZipFile;


function createFileObject(object $payload, DownloadConfig $config)
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
    $lang = $config->language;
    $filetype = \strtoupper($config->workbook_format->toString());
    return $payload->files->$lang->$filetype[0];
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
