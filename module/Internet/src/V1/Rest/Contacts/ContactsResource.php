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
        $productId = $this->getEvent()->getRouteMatch()->getParam('id');

    }
}
