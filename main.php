<?php

/*
* This is the main PHP file.
* It call the Post.php and UploadImg.php
* And it will automatically do the post via WordPress API.
*/

require_once __DIR__.'/../wp-admin/includes/post.php';
require_once __DIR__.'/../wp-admin/includes/image.php';

// include the Post and UploadImg class
require_once __DIR__.'/src/Valid.php';
require_once __DIR__.'/src/Post.php';
require_once __DIR__.'/src/UploadImg.php';

date_default_timezone_set('Asia/Taipei');

use peter\WordPress\Post;
use peter\WordPress\UploadImg;

$post = new Post('Test post', '<h2>This is the test post via WordPress API</h2>', '');

if($post->postFeed() === 'Post feed is successful.') {
    //$upload = new UploadImg($post);
    echo 'success...'.PHP_EOL;
}
