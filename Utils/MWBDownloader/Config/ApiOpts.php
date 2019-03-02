<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Config;

final class ApiOpts extends ConfigArrayValue
{
    protected const REQUIRED_KEYS = [
        CURLOPT_HEADER,
        CURLOPT_RETURNTRANSFER,
        CURLOPT_USERAGENT,
        CURLOPT_URL
    ];

    public function __construct(array $incomplete_opts, ApiUrl $url)
    {
        $complete_opts = $incomplete_opts + [CURLOPT_URL => (string) $url];
        
        parent::__construct($complete_opts);
    }

    public function withUrl(ApiUrl $url): self
    {
        $clone = clone $this;

        $clone[CURLOPT_URL] = (string) $url;

        return $clone;
    }
}
