<?php

/*
* This class validate the image id and post id.
*
*/

namespace peter\WordPress;

class Valid {
    public static function validateId(string $id) {
        $result = true;
        if(empty($id)) {
            $result = false;
        }

        return $result;
    }
}
