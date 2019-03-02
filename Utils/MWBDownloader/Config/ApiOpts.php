<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Config;


final class ApiOpts extends ConfigArrayValue
{
    protected const REQUIRED_KEYS = [
        CURLOPT_HEADER,
        CURLOPT_RETURNTRANSFER,
        CURLOPT_USERAGENT
    ];

    public function __construct(array $incomplete_opts, ApiUrl $url)
    {
        $this->container = $incomplete_opts;

        $this->container[CURLOPT_URL] = (string) $url;
    }

    public function withUrl(ApiUrl $url): self
    {
        $clone = clone $this;

        $clone[CURLOPT_URL] = (string) $url;

        return $clone;
    }
}
