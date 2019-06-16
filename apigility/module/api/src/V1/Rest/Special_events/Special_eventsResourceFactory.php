<?php
namespace api\V1\Rest\Special_events;

class Special_eventsResourceFactory
{
    public function __invoke($services)
    {
        return new Special_eventsResource();
    }
}
