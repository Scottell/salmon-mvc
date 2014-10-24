<?php

//include "rb.php";

class sampleController {
	
	public function add() {
		
		if (!Login::isLoggedIn()) {
			
			return new Result(Activity::SHARED, "login");
		}
		
		if ($_POST["name"] != NULL) {
		
			//$sample = R::dispense('sample');
			//$sample->name = $_POST["name"];
			//$id = R::store($sample);
	
			global $success;
			$success = true;
		}
		
		return new Result(Activity::VIEW);
	}
	
	public function delete($id) {
		
		if (!Login::isLoggedIn()) {
			
			return new Result(Activity::SHARED, "login");
		}
		
		//R::trash(R::load('sample', $id));
		
		return new Result(Activity::VIEW, true);
	}
	
	public function index() {
	
		//$model = R::findAll("sample", "order by id");
	
		return new Result(Activity::VIEW, $model);
	}

	public function fail() {

		throw new exception("test");
	}

    public function image() {

        $p = "images/logo.png";
        $handle = fopen($p, "r");
        $contents = fread($handle, filesize($p));
        fclose($handle);

        return new Result(Activity::IMAGE, $contents, "image/png");
    }
}

?>
