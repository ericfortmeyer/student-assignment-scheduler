<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Config;

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
