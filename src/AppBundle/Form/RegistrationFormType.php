<?php

/*
 * This file is part of the sf-facebook package.
 *
 * (c) Jason Hofer <jason.hofer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace AppBundle\Form;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RegistrationFormType
 *
 * @package AppBundle\Form
 * @author  Jason Hofer <jason.hofer@gmail.com>
 * 2017-07-11 12:55 AM
 */
class RegistrationFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('username')
            ->add('firstName', null, ['required' => true])
            ->add('lastName', null, ['required' => true])
        ;
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return BaseRegistrationFormType::class;
    }
}
