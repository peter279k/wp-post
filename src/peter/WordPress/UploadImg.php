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
    private $resultArr = [];
    private $resultMsg = '';

    public function __construct(array $settings) {
        $this->settings = $settings;
        if(!$this->isKeyExist()) {
            echo 'The upload image error';
        }
    }

    public function uploadImage($postId = 0) {
        for($index=0;$index<count($this->settings['name']);$index++) {
            $this->resultMsg = 'Upload images is successful.';
            $name = $this->settings['name'][$index];
            if(!file_exists($name)) {
                $this->resultArr[] = $name.' is not found.Skip...';
                continue;
            }
            $fileName = basename($name);
            $uploadFile = wp_upload_bits($fileName, null, file_get_contents($name));
            $content = $this->settings['content'][$index];
            if(!$uploadFile['error']) {
                $this->handleResult($fileName, $postId, $content, $uploadFile);
            }
        }

        return $this->resultArr;
    }

    public function uploadImageByUrl($postId = 0) {
        for($index=0;$index<count($this->settings['name']);$index++) {
            $this->resultMsg = 'Upload images is successful.';
            $link = $this->settings['name'][$index];
            $http = new \WP_Http();
            $response = $http->request($link);

            if($response['response']['code'] != 200) {
                $this->resultArr[] = 'failed to fetch the image link.';
                continue;
            }

            $fileName = basename($link);
            $fileName = explode('?', $val)[0];
            echo $fileName.PHP_EOL;
            $upload = wp_upload_bits($fileName, null, $response['body']);
            $content = $this->settings['content'][$index];
            $uploadDir = wp_upload_dir();
            if(!$upload['error']) {
                $guid = $uploadDir['url'].'/'.$fileName;
                $this->handleResult($fileName, $postId, $content, $upload, $guid);
            } else {
                echo $upload['error'].PHP_EOL;
            }
        }

        return $this->resultArr;
    }

    public function getImageUrlById($imageId) {
        return wp_get_attachment_url($imageId);
    }

    public function getImageId() {
        return $this->imageId;
    }

    private function handleResult($fileName, $postId, $content, $uploadFile, $guid = '') {
        $fileType = wp_check_filetype($fileName, null);
        $attachment = [
            'post_mime_type' => $fileType['type'],
            'post_parent' => $postId,
            'post_title' => preg_replace('/\.[^.]+$/', '', $fileName),
            'post_content' => $content,
            'post_status' => 'inherit',
        ];
        if($guid === '') {
            $attachment['guid'] = $wp_upload_dir['url'].'/'.$fileName;
        }
        $attachmentId = wp_insert_attachment($attachment, $uploadFile['file'], $postId);
        if(!is_wp_error($attachmentId)) {
            $attachmentData = wp_generate_attachment_metadata($attachmentId, $uploadFile['file']);
            wp_update_attachment_metadata($attachmentId,  $attachmentData);
            $this->resultArr[] = $attachmentId;
            $this->imageId = $attachmentId;
        } else {
            $this->resultMsg = 'Failed to upload images API via WordPress API.';
            $this->resultArr[] = $this->resultMsg;
        }
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
