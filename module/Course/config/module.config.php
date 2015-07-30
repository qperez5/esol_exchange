<?php

    return array(
        'router' => array(
            'routes' => array(
             'course' => array(
                    'type'    => 'segment',
                    'options' => array(
                        'route'    => '/courses[/:action][/:id]',
                        'constraints' => array(
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id'     => '[0-9]+',
                        ),
                        'defaults' => array(
                            'controller' => 'Course\Controller\Course',
                        ),
                    ),
                ),

            ),
        ),
        'controllers' => array(
            'invokables' => array(
                    'Course\Controller\Index' => 'Course\Controller\IndexController',
                    'Course\Controller\Course' => 'Course\Controller\CourseController',
            ),
        ),
        'view_manager' => array(
            'strategies' => array(
                'ViewJsonStrategy',
            ),
        ),
    );
