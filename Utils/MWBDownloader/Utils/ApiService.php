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

    public function getPayloadAsString(): string
    {
        $curl = $this->curl;
        return $curl($this->api_opts);
    }

    public function getPayloadAsObject(): object
    {
        $curl = $this->curl;
        
        return json_decode(
            $curl($this->api_opts)
        );
    }
}
