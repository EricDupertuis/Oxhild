<?php

namespace Oxhild\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

/**
 * Class AddCardForm
 *
 * @package Oxhild\ApiBundle\Form
 *
 * @author Eric Dupertuis <dupertuis.eric@gmail.com>
 */
class AddCardForm extends AbstractType
{
    /**
     * Builds the SearchCard form
     *
     * @param  \Symfony\Component\Form\FormBuilderInterface $builder
     * @param  array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            'entity',
            [
                'class' => 'OxhildApiBundle:Binder',
                'query_builder' => function (EntityRepository $er) use($options) {
                    return $er->createQueryBuilder('b')
                        ->where('b.user = :id')
                        ->setParameter('id', $options['attr']['user'])
                        ->orderBy('b.name', 'ASC');
                }
            ]
        )
            ->add('save', 'submit')
            ->getForm();
    }

    /**
     * Configure options
     *
     * @param OptionsResolver $resolvers
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Oxhild\ApiBundle\Entity\Binder',
            'user' => null
        ]);
    }

    /**
     * Get form name
     *
     * @return string
     */
    public function getName()
    {
        return 'oxhild_add_card';
    }
}