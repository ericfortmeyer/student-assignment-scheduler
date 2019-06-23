<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

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
