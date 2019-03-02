<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Config;

final class DownloadOptions extends ConfigArrayValue
{
    protected const REQUIRED_KEYS = [
        CURLOPT_URL,
        CURLOPT_FILE,
        CURLOPT_USERAGENT,
        CURLOPT_HEADER,
    ];
}
