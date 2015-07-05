<?php

namespace Oxhild\MtgBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem(
            'root',
            array(
                'childrenAttributes' => array(
                    'class' => 'nav navbar-nav navbar-right'
                )
            )
        );

        $menu->addChild('Home', array('route' => 'oxhild_homepage'));

        return $menu;
    }
}