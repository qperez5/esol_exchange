<?php
return array(
    'modules' => array(
        'Application',
        'Organization',
	    'Centre',
	    'Course',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        // local/global config location when needed
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
    ),
);
