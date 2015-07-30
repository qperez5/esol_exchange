<?php

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                 'type' => 'Zend\Mvc\Router\Http\Literal',
                 'options' => array(
                     'route'    => '/',
                     'defaults' => array(
                         'controller' => 'Application\Controller\Index',
                         'action' => 'index',
                     ),
                 ),
             ),

        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' =>   'Application\Controller\ApplicationController',
        ),
    ),

    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/index.html',
            'application/application/index'       => __DIR__ . '/../view/index.html',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
