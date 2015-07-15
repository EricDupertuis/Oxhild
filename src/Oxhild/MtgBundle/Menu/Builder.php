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
            $usr = $securityContext->getToken()->getUser();
            $username = $usr->getUsername();

            $menu->addChild($username, [
                'route' => 'oxhild_homepage',
                'attributes' => [
                    'class' => 'dropdown'
                ]
            ]);

            $menu[$username]->setChildrenAttribute('class', 'dropdown-menu')
                            ->setAttribute('class', 'dropdown')
                            ->setLinkAttributes([
                                'class' => 'dropdown-toggle',
                                'data-toggle' => 'dropdown',
                                'role' => 'button',
                                'aria-haspopup' => 'true',
                                'aria-expanded' => 'false'
                            ])
                            ->addChild('profile', ['route' => 'oxhild_homepage'])
            ;
        } else {
            $menu->addChild('login', ['route' => 'fos_user_security_login']);
        }

        return $menu;
    }
}