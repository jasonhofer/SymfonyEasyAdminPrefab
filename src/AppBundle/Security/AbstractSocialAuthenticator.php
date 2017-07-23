<?php

/*
 * This file is part of the parentalrestoration.org package.
 *
 * (c) Jason Hofer <jason.hofer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class AbstractSocialAuthenticator
 *
 * @package AppBundle\Security
 * @author  Jason Hofer <jason.hofer@gmail.com>
 * 2017-07-09 3:17 PM
 */
abstract class AbstractSocialAuthenticator extends SocialAuthenticator
{
    /** @var ClientRegistry */
    protected $clientRegistry;

    /** @var EntityManager */
    protected $em;

    /** @var RouterInterface */
    protected $router;

    /**
     * AbstractSocialAuthenticator constructor.
     *
     * @param ClientRegistry  $clientRegistry
     * @param EntityManager   $em
     * @param RouterInterface $router
     */
    public function __construct(ClientRegistry $clientRegistry, EntityManager $em, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em             = $em;
        $this->router         = $router;
    }

    abstract protected function getSocialType();
    abstract protected function applySocialUserData(User $user, ResourceOwnerInterface $socialUser);

    /**
     * @return string
     */
    protected function getSocialClientConfigName()
    {
        return $this->getSocialType().'_main';
    }

    /**
     * @return string
     */
    protected function getSocialTypeName()
    {
        return ucfirst($this->getSocialType());
    }

    protected function getCredentialsRoute()
    {
        return sprintf('connect_%s_check', $this->getSocialType());
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function isCredentialsRoute(Request $request)
    {
        return $this->getCredentialsRoute() === $request->attributes->get('_route');
    }

    /**
     * @param Request $request
     *
     * @return \League\OAuth2\Client\Token\AccessToken|null
     */
    public function getCredentials(Request $request)
    {
        if (!$this->isCredentialsRoute($request)) {
            // don't auth
            return null;
        }

        return $this->fetchAccessToken($this->getOAuth2Client());
    }

    protected function getSocialEmailAddress(ResourceOwnerInterface $socialUser)
    {
        if (!method_exists($socialUser, 'getEmail')) {
            throw new \BadMethodCallException('Method does not exist: '.get_class($socialUser).'::getEmail()');
        }

        return $socialUser->getEmail();
    }

    /**
     * @param mixed                 $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return \AppBundle\Entity\User
     *
     * @throws \Exception
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $socialUser = $this->getOAuth2Client()
            ->fetchUserFromToken($credentials);

        $repo = $this->em->getRepository('AppBundle:User');

        // 1) have they logged in with this social ID before? Easy!
        $existingUser = $repo->findOneBySocialId($this->getSocialType(), $socialUser->getId());

        if ($existingUser) {
            return $this->updateSocialUserData($existingUser, $socialUser);
        }

        // 2) do we have a matching user by email?
        $user = $repo->findOneByEmail($this->getSocialEmailAddress($socialUser));

        // 3) "Register" them by creating a User object
        if (!$user) {
            $user = new User();
        }

        return $this->updateSocialUserData($user, $socialUser);
    }

    /**
     * @param User                   $user
     * @param ResourceOwnerInterface $socialUser
     *
     * @return User
     *
     * @throws \Exception
     */
    protected function updateSocialUserData(User $user, ResourceOwnerInterface $socialUser)
    {
        $this->applySocialUserData($user, $socialUser);
        $user
            ->setSocialType($this->getSocialType())
            ->setSocialId($socialUser->getId())
            ->setSocialData($socialUser->toArray())
            ->setLoginMethod(User::LOGIN_METHOD_SOCIAL)
            ->setPlainPassword(hash('sha1', random_bytes(40)));

        if (!$user->getId()) {
            $user->setRoles(['ROLE_USER']);
            $this->em->persist($user);
            $this->em->flush();
        } else {
            $uow = $this->em->getUnitOfWork();
            $uow->computeChangeSets();
            if ($uow->isEntityScheduled($user)) {
                $this->em->flush();
            }
        }

        return $user;
    }

    /**
     * @return OAuth2Client
     */
    private function getOAuth2Client()
    {
        return $this->clientRegistry
            // This is the key used in config.yml (example: facebook_main)
            ->getClient($this->getSocialClientConfigName());
    }

    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     *
     * Examples:
     *  A) For a form login, you might redirect to the login page
     *      return new RedirectResponse('/login');
     *  B) For an API token authentication system, you return a 401 response
     *      return new Response('Auth header required', 401);
     *
     * @param Request                 $request       The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response|null
     *
     * @throws \Exception
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate('fos_user_security_login'));
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     *
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     *
     * @throws \Exception
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        /** @var Session $session */
        $session = $request->getSession();
        $session->getFlashBag()->add('error', 'Failed to login using your '.ucfirst($this->getSocialTypeName()).' account.');

        return new RedirectResponse($this->router->generate('fos_user_security_login'));
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param Request        $request
     * @param TokenInterface $token
     * @param string         $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     *
     * @throws \Exception
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $url = null;
        if (($session = $request->getSession()) && $session->has('_security.main.target_path')) {
            $url = $session->get('_security.main.target_path');
        }

        return new RedirectResponse($url ?: $this->router->generate('homepage'));
    }
}
