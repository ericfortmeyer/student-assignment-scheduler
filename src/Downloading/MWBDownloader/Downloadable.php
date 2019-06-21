<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Downloading\MWBDownloader;

/**
 * Defines an interface used for downloading a file.
 *
 * A client of an instance implementing this interface
 * can assume that it encapsulates all logic and information required to
 * download the file it represents.
 */
interface Downloadable
{
    /**
     * Download the file to the directory provided using
     * information and logic encapsulated by the implementor.
     *
     * As expected, this method is not a pure function since
     * the client would naturally expect the side effect
     * of a downloaded file.
     *
     * The return type is omitted for contravariance
     *
     * @param string $directory Destination of the file
     */
    public function downloadTo(string $directory);
}
