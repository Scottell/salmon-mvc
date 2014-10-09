<?php

class Result {
	
	private $action;
	private $subject;
	private $useLayout;
	
	function __construct($a, $s = NULL, $layout = false) {
	
		$this->action = $a;
		$this->subject = $s;
		$this->useLayout = $layout;
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
}


?>
