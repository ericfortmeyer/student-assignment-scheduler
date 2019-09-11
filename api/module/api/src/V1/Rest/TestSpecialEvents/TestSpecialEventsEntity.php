<?php
namespace api\V1\Rest\TestSpecialEvents;

class TestSpecialEventsEntity
{
    public $id;
    public $factual = "whatever";

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getArrayCopy()
    {
        return (array) $this;
    }
}
