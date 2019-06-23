<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Utils;

use StudentAssignmentScheduler\Downloading\MWBDownloader\Config\ApiCurlOptions;

final class ApiService
{
    /**
     * @var Curl $curl
     */
    private $curl;

    /**
     * @var ApiCurlOptions $api_opts
     */
    private $api_opts;

    public function __construct(ApiCurlOptions $api_opts)
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
