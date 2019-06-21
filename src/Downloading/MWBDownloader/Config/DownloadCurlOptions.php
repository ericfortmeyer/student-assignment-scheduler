<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Config;

final class DownloadCurlOptions extends ConfigArrayValue
{
    protected const REQUIRED_KEYS = [
        CURLOPT_URL,
        CURLOPT_FILE,
        CURLOPT_USERAGENT,
        CURLOPT_HEADER,
    ];
}
