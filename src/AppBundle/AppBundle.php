<?php

namespace AppBundle;

use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AppBundle
 *
 * @package AppBundle
 */
class AppBundle extends Bundle
{
    /** */
    public function __construct()
    {
        $this->name = 'AppBundle';
        $this->path = __DIR__;
    }

    /** @return string */
    public function getNamespace()
    {
        return __NAMESPACE__; // private $namespace;
    }

    /** @return string */
    public function getPath()
    {
        return __DIR__;
    }

    /**
     * @return bool
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            if (class_exists($class = 'DependencyInjection\AppBundleExtension')) {
                return $this->extension = new $class('app');
            }

            return $this->extension = false;
        }

        return $this->extension;
    }

    /**
     * @param Application $application
     */
    public function registerCommands(Application $application)
    {
        /* next_command */
    }

    /**
     * @return string|null
     */
    public function getParent()
    {
        return null;
    }
}
