<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Classes;

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

    public function toArray(): array
    {
        return $this->files->toArray();
    }

    public function reduce(\Closure $closure)
    {
        return $this->files->reduce($closure);
    }
}
