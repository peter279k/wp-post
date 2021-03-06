<?php

/*
* This is the main PHP file.
* It call the Post.php and UploadImg.php
* And it will automatically do the post via WordPress API.
* The post content example:
* <h2>This is the test post via WordPress API</h2>
* <img class="alignnone size-medium wp-image-24" src="https://ahong.space/wp-content/uploads/2017/09/21271347_1587217494679206_4543010444411136718_n-300x300.jpg" alt="" width="300" height="300" />
* <p>description1</p>
* <p>description2</p>
* <p>description3</p>
*/

// show the runtime error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// include the Post and UploadImg class
require_once __DIR__.'/src/autoloader.php';

date_default_timezone_set('Asia/Taipei');

use peter\WordPress\Post;
use peter\WordPress\UploadImg;

$title = 'Test post';
$content = '<h2>This is the test post via WordPress API</h2>';
$postName = '';
$category = [];

$post = new Post($title, $content, $postName, $category);
$uploadInfo = [
    'name' => ['https://scontent.ftpe7-1.fna.fbcdn.net/v/t1.0-9/14470520_1205931849474441_6469649795938442695_n.jpg?oh=e8e4245c44bf81fd6c02b779173a3913&oe=5A4C0FD7'],
    'title' => ['image1'],
    'content' => ['content1'],
    'type' => ['image/jpeg'],
];

$upload = new UploadImg($uploadInfo);

// call the UploadImg class to upload the images.
$resultSet = $upload->uploadImageByUrl();

foreach($resultSet as $value) {
    if((int)$value >= 0) {
        echo 'The image id is: '.$value.PHP_EOL;
    } else {
        echo $value.PHP_EOL;
    }
}

/*
echo PHP_EOL;

// call the Post class to post the feeds.
/*
if($post->postFeed() === 'Post feed is successful.') {
    echo 'The post id is: '.$post->getId().PHP_EOL;
}
*/
