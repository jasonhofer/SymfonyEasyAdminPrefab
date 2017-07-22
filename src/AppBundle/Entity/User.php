<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @param string $email
     *
     * @return self|\FOS\UserBundle\Model\UserInterface
     */
    public function setEmail($email)
    {
        parent::setUsername($email);

        return parent::setEmail($email);
    }


    public function setIsAdmin($flag)
    {
        if ($flag) {
            $this->addRole('ROLE_ADMIN');
        } else {
            $this->removeRole('ROLE_ADMIN');
        }

        return $this;
    }

    public function getIsAdmin()
    {
        return $this->hasRole('ROLE_ADMIN');
    }


    public function getIsSuperAdmin()
    {
        return $this->hasRole('ROLE_SUPER_ADMIN');
    }

    public function setIsSuperAdmin($flag)
    {
        if ($flag) {
            $this->addRole('ROLE_SUPER_ADMIN');
        } else {
            $this->removeRole('ROLE_SUPER_ADMIN');
        }

        return $this;
    }
}
