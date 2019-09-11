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
    Utils\BadRequestException,
    Utils\PageNotFoundException,
    Utils\InvalidUrlException,
    Utils\ServerFailureException,
    Config\DownloadConfig
};

/**
 * @param Month $month
 * @param DownloadConfig $config
 * @param string|null $destination
 * @throws BadRequestException|PageNotFoundException|InvalidUrlException|ServerFailureException
 */
function download(Month $month, DownloadConfig $config, ?string $destination = null): void
{
    $url = buildUrlUsingMonth(
        $month,
        $config->apiUrl,
        $config->apiQueryParams
    );

    createFileObject(
        (new ApiService($config->apiOpts($url)))
            ->getPayloadAsObject(),
        $config
    )->downloadTo($destination ?? $config->workbook_download_destination);
}
