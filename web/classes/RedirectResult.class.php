<?php

class RedirectResult {

	public $controller, $action, $id, $query;

	function __construct($action, $id = null, $controller = null, $query = null) {

		$this->action = $action;
		$this->id = $id;
		$this->controller = $controller;
		$this->query = $query;
	}
}

?>
