<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Parsing;

class DocumentWrapper
{
    /**
     * @var mixed
     */
    protected $document;

    public function __construct($document)
    {
        $this->document = $document;
    }

    public function getPages(): array
    {
        return $this->document->getPages();
    }

    public function getText(): string
    {
        return $this->document->getText();
    }

    public function getDetails(): array
    {
        return $this->document->getDetails();
    }
}
