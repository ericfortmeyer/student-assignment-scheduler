<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Config;

final class DownloadCurlOptions extends ConfigArrayValue
{
    protected const REQUIRED_KEYS = [
        CURLOPT_URL,
        CURLOPT_FILE,
        CURLOPT_USERAGENT,
        CURLOPT_HEADER,
    ];
}
