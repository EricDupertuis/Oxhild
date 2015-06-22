<?php

namespace Oxhild\MtgBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewBinder extends AbstractType
{


    public function getName()
    {
        return 'oxhild_new_binder';
    }
}