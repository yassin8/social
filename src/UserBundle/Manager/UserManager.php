<?php

namespace UserBundle\Manager;

use AppBundle\Entity\User;

/**
 * Class UserManager
 */
class UserManager
{
    /**
     * @var \FOS\UserBundle\Doctrine\UserManager
     */
    private $fosUserManager;

    /**
     * UserManager constructor.
     * @param $fosUserManager
     */
    public function __construct(\FOS\UserBundle\Doctrine\UserManager $fosUserManager)
    {
        $this->fosUserManager = $fosUserManager;
    }

    /**
     * @param array $data
     *
     * @return User
     */
    public function createUserFormLinkedInData(array $data)
    {
        $user = $this->fosUserManager->createUser();
        
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setLinkedInId($data['id']);
        $user->setDescription(isset($data['summary']) ? $data['summary'] : '');
        $user->setTitle($data['headline']);
        $user->setEmail($data['id'].'@linked.com');
        $user->setUsername($data['id'].'@linked.com');
        $user->setPassword($data['id'].'@linked.com');

        $this->fosUserManager->updateUser($user);

        return $user;
    }

    /**
     * @param int $linkedInId
     *
     * @return User
     */
    public function findUserByLinkedInId($linkedInId)
    {
        $user = $this->fosUserManager->findUserBy(array('linkedInId' => $linkedInId));

        return $user;
    }
}