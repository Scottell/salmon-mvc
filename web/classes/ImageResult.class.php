<?php

class ImageResult {

    public $type, $data;

    function __construct($data, $type=null) {

        $this->data = $data;
        $this->type = $type;
    }
}

?>
