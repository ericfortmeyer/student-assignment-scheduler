<?php

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
