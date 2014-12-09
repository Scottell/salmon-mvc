<?php

//include "rb.php";

class sampleController {
	
	public function add() {
		
		if (!Login::isLoggedIn()) {
			
			return new ViewResult(NULL, "login");
		}
		
		if ($_POST["name"] != NULL) {
		
			//$sample = R::dispense('sample');
			//$sample->name = $_POST["name"];
			//$id = R::store($sample);
	
			global $success;
			$success = true;
		}
		
		return new ViewResult();
	}
	
	public function delete($id) {
		
		if (!Login::isLoggedIn()) {
			
			return new ViewResult(NULL, "login");
		}
		
		//R::trash(R::load('sample', $id));
		
		return new Result(Activity::VIEW, NULL, true);
	}
	
	public function index() {
	
		//$model = R::findAll("sample", "order by id");
	
		return new ViewResult($model);
	}

	public function fail() {

		throw new exception("test");
	}

    public function image() {

        $p = "images/logo.png";
        $handle = fopen($p, "r");
        $contents = fread($handle, filesize($p));
        fclose($handle);

        return new ImageResult($contents, "image/png");
    }

    public function json() {

        return new JsonResult(array("Hi" => "hello"));
    }
}

?>
