<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Config;

final class ApiCurlOptions extends ConfigArrayValue
{
    protected const REQUIRED_KEYS = [
        CURLOPT_HEADER,
        CURLOPT_RETURNTRANSFER,
        CURLOPT_USERAGENT
    ];

    public function __construct(array $incomplete_opts, ApiUrl $url)
    {
        parent::__construct($incomplete_opts);
        $this->container[CURLOPT_URL] = (string) $url;
    }
}
