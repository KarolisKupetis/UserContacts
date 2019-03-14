<?php
namespace Internet\V1\Rest\Contacts;

class ContactsResourceFactory
{
    public function __invoke($services)
    {
        return new ContactsResource();
    }
}
