<?php

namespace Users\Repository;

use Doctrine\ORM\EntityRepository;

class UsersRepository extends EntityRepository
{
    public function getById($userId)
    {
        $userContacts = $this->findOneBy(['id' => $userId]);

        if ($userContacts === null) {
            throw new \Exception('User by that ID does not exist');
        }

        return $userContacts;
    }
}