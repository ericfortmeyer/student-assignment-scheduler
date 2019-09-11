<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
 declare(strict_types=1);

namespace StudentAssignmentScheduler\BackupAndRestore;

use \Ds\Set;

final class ListOfFiles
{
    /**
     * @var Set $files
     */
    private $files;

    public function __construct(\Traversable $traversable = null)
    {
        $this->files = $traversable ? new Set($traversable) : new Set();
    }

    public function add(File $file)
    {
        $this->files->add($file);
    }

    public function reduce(\Closure $closure)
    {
        return $this->files->reduce($closure);
    }
}
