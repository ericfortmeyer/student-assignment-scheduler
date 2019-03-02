<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Utils;

use StudentAssignmentScheduler\Utils\MWBDownloader\Config\ApiOpts;
use StudentAssignmentScheduler\Utils\MWBDownloader\Config\ApiUrl;

final class ApiService
{
    /**
     * @var Curl $curl
     */
    private $curl;

    /**
     * @var ApiOpts $api_opts
     */
    private $api_opts;

    public function __construct(ApiOpts $api_opts)
    {
        $this->api_opts = $api_opts;
        $this->curl = new Curl();
    }

    public function getPayloadAsString(ApiUrl $url): string
    {
        $curl = $this->curl;
        return $curl($url, $this->api_opts);
    }

    public function getPayloadAsObject(ApiUrl $url): object
    {
        $curl = $this->curl;
        
        return json_decode(
            $curl($url, $this->api_opts)
        );
    }
}
