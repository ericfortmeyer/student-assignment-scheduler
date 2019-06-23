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

use \DateTimeImmutable;

use StudentAssignmentScheduler\Downloading\MWBDownloader\{
    Month,
    Config\ApiUrl,
    Config\ApiQueryParams
};

/**
 * @param Month $month
 * @param ApiUrl $url
 * @param ApiQueryParams $api_query_params
 * @param string|null $year = null
 */
function buildUrlUsingMonth(
    Month $month,
    ApiUrl $url,
    ApiQueryParams $api_query_params,
    ?string $year = null
): ApiUrl {
    /**
     * TODO: change to account for months early in the following year
     */
    $year = $year ?? (new DateTimeImmutable())->format("Y");
    
    return $url->withParams(
        $api_query_params
            ->withIssueParam("$year$month")
            ->toArray()
    );
}
