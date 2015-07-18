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
            $username = ucfirst($usr->getUsername());

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
                            ]);

            $menu[$username]->addChild('My Binders', [
                'route' => 'oxhild_homepage'
            ]);

            $menu[$username]->addChild('Profile', [
                'route' => 'fos_user_profile_show',
                'attributes' => [
                    'class' => 'text-danger'
                ]
            ]);

            $menu[$username]->addChild('separator', [
                'attributes' => [
                    'class' =>  'divider'
                ]
            ]);

            $menu[$username]->addChild('Logout', [
                'route' => 'fos_user_security_logout',
            ]);
        } else {
            $menu->addChild('login', ['route' => 'fos_user_security_login']);
            $menu['login']->setAttribute('class', 'text-danger');
        }

        return $menu;
    }
}