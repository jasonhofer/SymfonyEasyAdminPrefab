<?php

/*
 * This file is part of the sf-facebook package.
 *
 * (c) Jason Hofer <jason.hofer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Security;

use AppBundle\Entity\User;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * Class GoogleAuthenticator
 *
 * @package AppBundle\Security
 * @author  Jason Hofer <jason.hofer@gmail.com>
 * 2017-07-09 10:47 PM
 */
class GoogleAuthenticator extends AbstractSocialAuthenticator
{
    protected function getSocialType()
    {
        return 'google';
    }

    protected function applySocialUserData(User $user, ResourceOwnerInterface $socialUser)
    {
        /** @var GoogleUser $socialUser */
        $user
            ->setFirstName($socialUser->getFirstName())
            ->setLastName($socialUser->getLastName())
            ->setEmail($email = $socialUser->getEmail())
            ->setUsername($email)
            ->setAvatar($socialUser->getAvatar())
            // @TODO Can we get more google user data?
            //->setLocale($socialUser->getLocale())
            //->setTimezone($socialUser->getTimezone())
            //->setGender($socialUser->getGender())
        ;
    }
}
