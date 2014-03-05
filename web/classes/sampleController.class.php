<?php

//include "rb.php";

class sampleController {
	
	public function add() {
		
		if (!Login::isLoggedIn()) {
			
			return new Result(Action::SHARED, "login");
		}
		
		if ($_POST["name"] != NULL) {
		
			//$sample = R::dispense('sample');
			//$sample->name = $_POST["name"];
			//$id = R::store($sample);
	
			global $success;
			$success = true;
		}
		
		return new Result(Action::VIEW);
	}
	
	public function delete($id) {
		
		if (!Login::isLoggedIn()) {
			
			return new Result(Action::SHARED, "login");
		}
		
		//R::trash(R::load('sample', $id));
		
		return new Result(Action::VIEW);
	}
	
	public function index() {
	
		//$model = R::findAll("sample", "order by id");
	
		return new Result(Action::VIEW, $model);
	}
}

?>