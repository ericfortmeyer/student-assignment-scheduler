<?php
namespace api\V1\Rest\Contacts;

class ContactsResourceFactory
{
    public function __invoke($services)
    {
        return new ContactsResource();
    }
}
