<?php

class Result {
	
	private $action;
	private $subject;
	private $useLayout;
	private $view;
	
	function __construct($a,
		$s = NULL,
		$layout = false,
		$v = NULL) {
	
		$this->action = $a;
		$this->subject = $s;
		$this->useLayout = $layout;
		$this->view = $v;
	}
	
	public function getAction() {
		return $this->action;
	}
	
	public function getSubject() {
		return $this->subject;
	}

	public function getUseLayout() {
		return $this->useLayout;
	}

	public function getView() {
		return $this->view;
	}
}


?>
