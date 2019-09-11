<?php
namespace api\V1\Rest\Schedule_recipients;

class Schedule_recipientsResourceFactory
{
    public function __invoke($services)
    {
        return new Schedule_recipientsResource();
    }
}
