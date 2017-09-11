<?php

require_once __DIR__.'/../../wp-load.php';
require_once __DIR__.'/../../wp-admin/includes/post.php';
require_once __DIR__.'/../../wp-admin/includes/image.php';

// include the WP_Http class for HTTP request
require_once __DIR__.'/../../wp-includes/class-http.php';

spl_autoload_register(function ($class) {
    require_once __DIR__.'/'.str_replace('\\', '/', $class).'.php';
});
