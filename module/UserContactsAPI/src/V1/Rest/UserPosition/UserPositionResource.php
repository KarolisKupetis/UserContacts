<?php
namespace UserContactsAPI\V1\Rest\UserPosition;

use UserContacts\Service\UserPositionService;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class UserPositionResource extends AbstractResourceListener
{

    /**
     * @var UserPositionService
     */
    private $positionService;

    public function __construct(UserPositionService $positionService)
    {

        $this->positionService = $positionService;
    }

    /**
     * @param mixed $data
     *
     * @return mixed|void|ApiProblem
     * @throws \UserContacts\Exceptions\InvalidUserPositionException
     * @throws \UserContacts\Exceptions\NotExistingUserContactsException
     */
    public function create($data)
    {
       $positionParams ['userId'] = $this->getEvent()->getRouteMatch()->getParam('id');
       $positionParams ['position'] = $data->position;

       $this->positionService->addUserPosition($positionParams);

       return ['id' =>1];
    }

}
