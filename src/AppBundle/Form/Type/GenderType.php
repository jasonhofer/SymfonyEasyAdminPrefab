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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GenderType
 *
 * @package AppBundle\Form\Type
 * @author  Jason Hofer <jason.hofer@gmail.com>
 * 2017-07-23 2:12 AM
 */
class GenderType extends AbstractType
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('choices', [
            'Female' => 'female',
            'Male'   => 'male',
            'Other'  => 'other',
        ]);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'gender';
    }
}
