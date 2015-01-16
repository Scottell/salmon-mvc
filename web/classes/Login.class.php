<?php

class Login {
	
	public static function isLoggedIn() {
		
		$key = 'loggedin';
		session_start();
		
		if (isset($_SESSION[$key])) {
			return true;
		} 
		
		if ($_POST['pw'] == 'password')  {
					
			$_SESSION[$key] = true;
			Mvcer::postHandled();
			return true;
		}
		
		return false;
	}
}


?>
