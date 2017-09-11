<?php

// include the wp-load, post functions and image functions.
require_once __DIR__.'/../../wp-load.php';
require_once __DIR__.'/../../wp-admin/includes/post.php';
require_once __DIR__.'/../../wp-admin/includes/image.php';

// include the WP_Http class for HTTP request
require_once __DIR__.'/../../wp-includes/class-http.php';

function autoloader($class) {
    $folders = ['/peter/WordPress/'];
    foreach($folders as $file) {
        $filePath = __DIR__.$file.$class.'.php';
    }
}

spl_autoload_register('autoloader');
