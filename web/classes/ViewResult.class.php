<?php

class ViewResult {

    public $model, $view, $layout, $controller, $shared;

    function __construct($model = null,
                         $view = null,
                         $controller = null,
                         $layout = true) {

        $this->model = $model;
        $this->view = $view;
        $this->controller = $controller;
        $this->layout = $layout;
    }
}

?>
