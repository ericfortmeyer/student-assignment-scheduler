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

    public function withUrl(ApiUrl $url): self
    {
        $clone = clone $this;

        $clone[CURLOPT_URL] = (string) $url;

        return $clone;
    }
}
