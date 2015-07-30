<?php

return array(
    'router' => array(
        'routes' => array(
            'centre' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/centres[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Centre\Controller\Centre',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Centre\Controller\Index' => 'Centre\Controller\IndexController',
            'Centre\Controller\Centre' => 'Centre\Controller\CentreController',
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
