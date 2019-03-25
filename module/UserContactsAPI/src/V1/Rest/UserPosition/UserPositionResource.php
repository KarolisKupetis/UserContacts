<?php
namespace UserContactsAPI\V1\Rest\UserPosition;

use UserDetails\Service\UserPositionService;
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
     * @return array|mixed|ApiProblem
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \UserDetails\Exceptions\InvalidUserPositionException
     * @throws \UserDetails\Exceptions\NotExistingUserContactsException
     */
    public function create($data)
    {
       $positionParams ['userId'] = $this->getEvent()->getRouteMatch()->getParam('id');
       $positionParams ['position'] = $data->position;

        $position =  $this->positionService->addUserPosition($positionParams);

       return UserPositionEntity::fromPositionEntity($position);
    }

}
