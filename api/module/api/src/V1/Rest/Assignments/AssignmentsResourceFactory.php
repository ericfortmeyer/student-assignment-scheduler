<?php
namespace api\V1\Rest\Assignments;

class AssignmentsResourceFactory
{
    public function __invoke($services)
    {
        return new AssignmentsResource();
    }
}
