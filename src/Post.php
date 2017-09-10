<?php

/*
* This class can post the feed via WordPress API
*/

namespace peter\WordPress;

class Post {

    private $postTitle = '';
    private $postContent = '';
    private $postName = '';

    public function __construct($postTitle, $postContent, $postName) {
        $this->postTitle = $postTitle;
        $this->postContent = $postContent;
        $this->postName = $postName;
    }

    public function postFeed() {
        $resultMsg = 'Post feed is successful.';
        $id = wp_insert_post([
            'post_title'    => $postTitle,
            'post_content'  => $postContent,
            'post_date'     => date('Y-m-d H:i:s'),
            'post_author'   => $postName,
            'post_type'     => 'post',
            'post_status'   => 'publish',
        ]);
        $result = Valid::validateId((string)$id);
        $resultMsg = $id;
        if(!$result) {
            $resultMsg = 'Failed to post feed via WordPress API.';
        }

        return $resultMsg;
    }
}
