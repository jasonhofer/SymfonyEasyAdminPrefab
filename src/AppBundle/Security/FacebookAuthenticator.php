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
use League\OAuth2\Client\Provider\FacebookUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * Class FacebookAuthenticator
 *
 * @package AppBundle\Security
 * @author  Jason Hofer <jason.hofer@gmail.com>
 * 2017-07-09 10:44 PM
 */
class FacebookAuthenticator extends AbstractSocialAuthenticator
{
    protected function getSocialType()
    {
        return 'facebook';
    }

    protected function applySocialUserData(User $user, ResourceOwnerInterface $socialUser)
    {
        /** @var FacebookUser $socialUser */
        $user->setFirstName($socialUser->getFirstName());
        $user->setLastName($socialUser->getLastName());
        $user->setGender($socialUser->getGender());
        $user->setEmail($email = $socialUser->getEmail());
        $user->setUsername($email);
        $user->setTimezone($socialUser->getTimezone());
        $user->setLocale($socialUser->getLocale());
        $user->setAvatar($socialUser->getPictureUrl());
    }
}
