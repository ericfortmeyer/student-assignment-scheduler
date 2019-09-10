<?php
namespace api\V1\Rest\TemplatesForIncompleteMonthsOfAssignments;

class TemplatesForIncompleteMonthsOfAssignmentsResourceFactory
{
    public function __invoke($services)
    {
        return new TemplatesForIncompleteMonthsOfAssignmentsResource();
    }
}
