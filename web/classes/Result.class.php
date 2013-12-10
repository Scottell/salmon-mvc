<?php

class Result {
	
	private $action;
	private $subject;
	
	function __construct($a, $s = NULL) {
	
		$this->action = $a;
		$this->subject = $s;
	}
	
	public function getAction() {
		return $this->action;
	}
	
	public function getSubject() {
		return $this->subject;
	}
}


?>