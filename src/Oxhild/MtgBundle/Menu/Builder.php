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
            [
                'childrenAttributes' => [
                    'class' => 'nav navbar-nav navbar-right'
                ]
            ]
        );

        $menu->addChild('Home', ['route' => 'oxhild_homepage']);
        $menu->addChild('Explore', ['route' => 'oxhild_homepage']);


        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {

        }

        return $menu;
    }
}