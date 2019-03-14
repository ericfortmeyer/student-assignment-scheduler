<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader;

/**
 * Defines an interface used to validate a file.
 *
 * A client of an instance implementing this interface
 * can assume that it encapsulates all logic and information required to
 * validate the file it represents.
 */
interface Validatable
{
    /**
     * Validate the file using the logic and information
     * encapsulated by the implementor.
     *
     * An instance implementing this interface should
     * handle success and error cases.
     *
     * Provide the full path to the file in case
     * error handling requires that an invalid file
     * be deleted from the file system.
     *
     * @param string $full_path_to_file
     */
    public function handleValidation(string $full_path_to_file);
}
