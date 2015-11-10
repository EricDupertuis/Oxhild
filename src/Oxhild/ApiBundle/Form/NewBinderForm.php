<?php

namespace Oxhild\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NewBinderForm
 *
 * @package Oxhild\ApiBundle\Form
 *
 * @author Eric Dupertuis <dupertuis.eric@gmail.com>
 */
class NewBinderForm extends AbstractType
{

    /**
     * New Binder Form
     *
     * @param  \Symfony\Component\Form\FormBuilder $builder
     * @param  array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
            ->add('description', 'text')
            ->add('private', 'checkbox', array(
                'required' => false
            ))
            ->add('save', 'submit')
            ->getForm();
    }

    /**
     * Configure options
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Oxhild\ApiBundle\Entity\Binder'
            )
        );
    }

    /**
     * Get form name
     *
     * @return string
     */
    public function getName()
    {
        return 'oxhild_new_binder';
    }
}