<?php
namespace api\V1\Rest\TestSpecialEvents;

class TestSpecialEventsResourceFactory
{
    public function __invoke($services)
    {
        return new TestSpecialEventsResource();
    }
}
