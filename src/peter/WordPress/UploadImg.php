<?php

/*
* This class helps you upload the image via WordPress API easily.
* The parameter array settings sample:
* $settings = ['name' => [], 'title' => [], 'content' => [], 'type' => []]
* uploadImage: upload the image.
* getImageId: get the current image id.
* getImageUrlById: get the current image url by id.
*
*/

namespace peter\WordPress;

class UploadImg {

    private $settings = [];
    private $imageId = 0;

    public function __construct(array $settings) {
        $this->settings = $settings;
        if(!$this->isKeyExist()) {
            echo 'The upload image error';
        }
    }

    public function uploadImage($postId = 0) {
        $resultArr = [];

        $uploadDir = wp_upload_dir();
        for($index=0;$index<count($this->setting['name']);$index++) {
            $resultMsg = 'Upload images is successful.';
            $name = $this->setting['name'][$index];
            if(!file_exists($name)) {
                $resultArr[] = $name.' is not found.Skip...';
                continue;
            }
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
                $resultArr[] = $resultMsg;
            } else {
                $resultArr[] = $imageId;
            }

            // Generate the metadata for the attachment, and update the database record.
            $attachData = wp_generate_attachment_metadata($imageId, $name);

            wp_update_attachment_metadata($imageId, $attachData);
        }
        return $resultArr;
    }

    public function getImageUrlById($imageId) {
        return wp_get_attachment_url($imageId);
    }

    private function isKeyExist() {
        $result = true;
        $key = ['name', 'title', 'content', 'type'];
        foreach($key as $val) {
            if(!array_key_exists($val, $this->settings)) {
                $result = false;
            }
        }

        return $result;
    }
}
