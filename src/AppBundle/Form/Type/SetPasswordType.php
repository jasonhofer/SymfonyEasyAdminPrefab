<?php

/*
 * This file is part of the symfony-skeleton2 package.
 *
 * (c) Jason Hofer <jason.hofer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * Class SetPasswordType
 *
 * @package AppBundle\Form\Type
 * @author  Jason Hofer <jason.hofer@gmail.com>
 * 2017-07-23 2:22 AM
 */
class SetPasswordType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     *
     * @throws \Exception
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('type', PasswordType::class);
        $resolver->setDefault('first_options',  ['label' => 'Password']);
        $resolver->setDefault('second_options', ['label' => 'Confirm Password']);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return RepeatedType::class;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'set_password';
    }
}

