<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Functions;

use StudentAssignmentScheduler\Utils\MWBDownloader\{
    Month,
    Utils\ApiService,
    Config\DownloadConfig
};

/**
 * @param Month $month
 * @param DownloadConfig $config
 * @param string|null $destination
 * @throws \Exception
 */
function download(Month $month, DownloadConfig $config, ?string $destination = null): void
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

    $fileObj->downloadTo($destination ?? $config->workbook_download_destination);
}
