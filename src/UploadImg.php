<?php

/*
* This class helps you upload the image via WordPress API easily.
* The parameter array settings sample:
* $settings = ['name' => [], 'title' => [], 'content' => [], 'type' => []]
*/

namespace peter\WordPress;

class UploadImg {

    private $settings = [];
    private $imageId = 0;

    public function __construct(array $settings) {
        $this->settings = $settings;
    }

    private function uploadImage($postId) {
        $resultMsg = 'Upload images is successful.';

        if(!array_key_exists(['name', 'title', 'content'], $this->settings)) {
            echo 'The upload image error';
        }
        $images = $this->settings['name'];
        $uploadDir = wp_upload_dir();
        for($index=0;$index<count($this->setting['name']);$index++) {
            $name = $this->setting['name'][$index];
            $type = $this->setting['type'][$index];
            $title = $this->setting['title'][$index];
            $content = $this->setting['content'][$index];
            $attachment = array(
                'guid' => $uploadDir['url'].'/'.basename($name),
                'post_mime_type' => $type,
                'post_title' => $title,
                'post_content' => $content,
                'post_status' => 'inherit'
            );

            $imageId = wp_insert_attachment($attachment, $name, $postId);
            $this->imageId = $imageId;

            $result = $this->validateId($id);
            if(!$result) {
                $resultMsg = 'Failed to upload images API via WordPress API.';
            }

            // Generate the metadata for the attachment, and update the database record.
            $attachData = wp_generate_attachment_metadata($imageId, $name);

            wp_update_attachment_metadata($imageId, $attachData);

            return $resultMsg;
        }
    }

    public function getImageId() {
        return $this->imageId;
    }
}
