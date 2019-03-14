<?php
namespace Internet\V1\Rest\Contacts;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class ContactsResource extends AbstractResourceListener
{
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(404,'POST method not allowed');
    }
}
