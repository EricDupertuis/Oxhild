<?php

namespace Oxhild\MtgBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class AddCardForm extends AbstractType
{
    /**
     * Builds the SearchCard form
     * @param  \Symfony\Component\Form\FormBuilderInterface $builder
     * @param  array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'entity', [
                'class' => 'OxhildMtgBundle:Binder',
                'query_builder' => function (EntityRepository $er) use($options) {
                    return $er->createQueryBuilder('b')
                        ->where('b.user = :id')
                        ->setParameter('id', $options['attr']['user'])
                        ->orderBy('b.name', 'ASC');
                }
            ])
            ->add('save', 'submit')
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Oxhild\MtgBundle\Entity\Binder',
            'user' => null
        ));
    }

    public function getName()
    {
        return 'oxhild_add_card';
    }
}