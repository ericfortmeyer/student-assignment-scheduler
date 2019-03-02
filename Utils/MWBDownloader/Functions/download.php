<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Functions;

use StudentAssignmentScheduler\Utils\MWBDownloader\Config\DownloadConfig;
use StudentAssignmentScheduler\Utils\MWBDownloader\Month;
use StudentAssignmentScheduler\Utils\MWBDownloader\Utils\ApiService;

/**
 * @param Month $month
 * @param DownloadConfig $config
 * @throws \Exception
 */
function download(Month $month, DownloadConfig $config): void
{
    $url = buildUrlUsingMonth(
        $month,
        $config->apiUrl,
        $config->apiQueryParams
    );

    $fileObj = createFileObject(
        (new ApiService($config->apiOpts($url)))
            ->getPayloadAsObject(),
        $config
    );

    $fileObj
        ->downloadToDirectory($config->workbook_download_destination)
        ->handleFileValidation();
}
