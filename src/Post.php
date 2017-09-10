<?php

/*
* This class can post the feed via WordPress API
*/

namespace peter\WordPress;

class Post {

    private $postTitle = '';
    private $postContent = '';
    private $postName = '';
    private $postCategory = [];
    private $id = 0;

    public function __construct($postTitle, $postContent, $postName, $postCategory = []) {
        $this->postTitle = $postTitle;
        $this->postContent = $postContent;
        $this->postName = $postName;
        $this->postCategory = $postCategory;
    }

    public function postFeed() {
        $resultMsg = 'Post feed is successful.';
        $id = wp_insert_post([
            'post_title'    => $this->postTitle,
            'post_content'  => $this->postContent,
            'post_author'   => $this->postName,
            'post_type'     => 'post',
            'post_status'   => 'publish',
            'post_category' => $this->postCategory,
        ]);
        $this->id = $id;
        $result = Valid::validateId($id);
        if(!$result) {
            $resultMsg = 'Failed to post feed via WordPress API.';
        }

        return $resultMsg;
    }

    public function getId() {
        return $this->id;
    }
}
