<?php

namespace StudentAssignmentScheduler\Parsing;

/**
 * Use this wrapper as an interface to document objects.
 * 
 * Since an instance of a document object could be a
 * result of a 3rd party library or a module in this application
 * parsing a document, this wrapper ensures that an API will be available
 * to it's client.
 */
class DocumentWrapper
{
    /**
     * @var mixed
     */
    protected $document;

    /**
     * Create the instance.
     * 
     * @param mixed $document
     */
    public function __construct($document)
    {
        $this->document = $document;
    }

    /**
     * Return an array of page objects from
     * the document.
     * 
     * @return object[]
     */
    public function getPages(): array
    {
        return $this->document->getPages();
    }

    /**
     * Return the content of the document.
     * @codeCoverageIgnore
     * 
     * @return string
     */
    public function getText(): string
    {
        return $this->document->getText();
    }

    /**
     * Return an array of details
     * about the document.
     * @return array
     */
    public function getDetails(): array
    {
        return $this->document->getDetails();
    }
}
