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
