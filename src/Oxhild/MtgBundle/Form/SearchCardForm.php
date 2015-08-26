<?php

namespace Oxhild\MtgBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SearchCardForm
 *
 * @package Oxhild\MtgBundle\Form
 *
 * @author Eric Dupertuis <dupertuis.eric@gmail.com>
 */
class SearchCardForm extends AbstractType
{
    /**
     * Builds the SearchCard form
     *
     * @param  \Symfony\Component\Form\FormBuilder $builder
     * @param  array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('label' => 'Card'))
            ->getForm();
    }

    /**
     * Configure options
     *
     * @param OptionsResolver $resolvers Form Options resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Oxhild\MtgBundle\Entity\Card'
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
        return 'oxhild_search_card';
    }
}