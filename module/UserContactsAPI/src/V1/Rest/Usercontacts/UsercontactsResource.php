<?php
namespace UserContactsAPI\V1\Rest\Usercontacts;

use Users\Entity\User;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class UsercontactsResource extends AbstractResourceListener
{
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
            return new ApiProblem(405, 'The POST method has  been defined');
    }
}
