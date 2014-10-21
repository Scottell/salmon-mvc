<?php

class Result {
	
	private $activity;
	private $subject;
	private $useLayout;
	private $view;
	
	function __construct($a,
		$s = NULL,
		$layout = false,
		$v = NULL) {
	
		$this->activity = $a;
		$this->subject = $s;
		$this->useLayout = $layout;
		$this->view = $v;
	}
	
	public function getActivity() {
		return $this->activity;
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
