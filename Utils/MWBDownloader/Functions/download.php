<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Functions;

use StudentAssignmentScheduler\Utils\MWBDownloader\Config\DownloadConfig;
use StudentAssignmentScheduler\Utils\MWBDownloader\Month;
use StudentAssignmentScheduler\Utils\MWBDownloader\Utils\ApiService;

function download(Month $month, DownloadConfig $config): void
{
    try {
        $url = buildUrlUsingMonth(
            $month,
            $config->apiUrl,
            $config->apiQueryParams
        );

        $fileObj = createFileObject(
            (new ApiService($config->apiOpts($url)))
                ->getPayloadAsObject($url),
            $config
        );


        $fileObj
            ->downloadToDirectory($config->workbook_download_destination)
            ->handleFileValidation();
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}
