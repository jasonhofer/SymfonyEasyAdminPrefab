<?php

/*
 * This file is part of the sf-facebook package.
 *
 * (c) Jason Hofer <jason.hofer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class SecurityController
 *
 * @package AppBundle\Controller
 * @author  Jason Hofer <jason.hofer@gmail.com>
 * 2017-07-09 3:03 PM
 */
class SecurityController extends Controller
{
    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/facebook", name="connect_facebook")
     */
    public function connectFacebookAction()
    {
        // will redirect to Facebook!
        return $this->get('oauth2.registry')
            ->getClient('facebook_main') // key used in config.yml
            ->redirect();
    }

    /**
     * After going to Facebook, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config.yml
     *
     * @Route("/connect/facebook-check", name="connect_facebook_check")
     */
    public function connectFacebookCheckAction()
    {
    }

    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/google", name="connect_google")
     */
    public function connectGoogleAction()
    {
        // will redirect to Google!
        return $this->get('oauth2.registry')
            ->getClient('google_main') // key used in config.yml
            ->redirect();
    }

    /**
     * After going to Google+, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config.yml
     *
     * @Route("/connect/google-check", name="connect_google_check")
     */
    public function connectGoogleCheckAction()
    {
    }
}
