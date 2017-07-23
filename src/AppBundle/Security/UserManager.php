<?php

/*
 * This file is part of the symfony-skeleton2 package.
 *
 * (c) Jason Hofer <jason.hofer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace AppBundle\Security;

use AppBundle\Entity\User;
use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;

/**
 * Class UserManager
 *
 * @package AppBundle\Security
 * @author  Jason Hofer <jason.hofer@gmail.com>
 * 2017-07-23 2:44 PM
 */
class UserManager extends BaseUserManager
{
    /**
     * @return User
     */
    public function createUser()
    {
        $user = new User();

        $user->setCreatedAt(new \DateTime('now'));
        $user->setEnabled(true);
        $user->addRole('ROLE_USER');

        return $user;
    }

    /** @noinspection GenericObjectTypeUsageInspection
     *
     * @param string $socialType
     * @param string $socialId
     *
     * @return User|object|null
     */
    public function findUserBySocialId($socialType, $socialId)
    {
        return $this->getRepository()->findOneBy([
            'socialType' => $socialType,
            'socialId'   => $socialId,
        ]);
    }
}
