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

final class ApiQueryParams extends ConfigArrayValue
{
    protected const REQUIRED_KEYS =  [
        "output",
        "fileformat",
        "pub",
        "alllangs",
        "langwritten"
    ];

    public function withIssueParam(string $issue_param_value): self
    {
        $clone = clone $this;
        $clone["issue"] = $issue_param_value;

        return $clone;
    }
}
