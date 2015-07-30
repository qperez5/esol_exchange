<?php

return array(
    'router' => array(
        'routes' => array(

            'organization' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/organizations[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Organization\Controller\Organization',
                       // 'action'     => 'index',
                    ),
                ),
            ),

        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Organization\Controller\Index' => 'Organization\Controller\IndexController',
            'Organization\Controller\Organization' => 'Organization\Controller\OrganizationController',
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
