<?php
$env = getenv('APP_ENV') ?: 'production';

$config_paths = array(
    'config/autoload/{,*.}{global,local}.php',
);

if($env == 'production'){
    $config_paths = array(
        'config/autoload/{,*.}{global,production}.php',
    );
}

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
        'config_glob_paths' => $config_paths,
    ),
);
