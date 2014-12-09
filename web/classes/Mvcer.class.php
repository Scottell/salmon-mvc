<?php

class Mvcer {
	
	private static $controller, $action, $baseDir;
	
	public static $layout = "_layout";
	public static $contentDir = "content";

	public static function run($defaultController = NULL,
		$defaultAction = "index") {
		
		//echo  $_SERVER['PHP_SELF'];
		
		// parse uri
		// {site root}/{controller}/{view}[/{id}][?{field}={value}[&...]]
		$uri = $_SERVER["REQUEST_URI"];
		
		// snip off query string
		$qidx = strpos($uri, "?");
		if ($qidx > 0) {
		
			//parse_str($uri, $opts);
			$uri = substr($uri, 0, $qidx);
		}
		//else $opts = array();
		
		$params = explode( '/', $uri );
		
		// start from {site root}.  use script url to find
		$idx = count(explode('/',  $_SERVER['PHP_SELF'])) - 1; 
		self::$baseDir = dirname($_SERVER['PHP_SELF']);
		
		// get controller
		self::$controller = $controller = $params[$idx] ?  $params[$idx++] : $defaultController;
		$cn = $controller . "Controller";
		
		if (!class_exists($cn)) {
			echo("No controller found for model '$controller'.");
			die();
		}
		
		// instantiate controller from string
		$c = new $cn;
		
		// get controller method
		self::$action = $action = $params[$idx] ? $params[$idx++] : $defaultAction;
		if (!is_callable(array($c, $action))) {
		
			// todo: add error page functionality
			echo "page not found";
			return;
		}
		
		$id = count($params) > 2 ? $params[$idx++] : NULL;
		//$opts["id"] = $id;
		
		// prevent controller from outputting response
		//ob_start();
		
		try {

			// call controller method
			$r = call_user_func(array($c, $action), $id);

		} catch (exception $e) {

			$r = new ViewResult(null, "error");
		}
		
		// throw away any response
		//ob_end_clean();

		if (is_null($r)) return;

		//$activity = $r->getActivity();
		//if ($activity == Activity::VIEW) {
		if ($r instanceof ViewResult) {

			$c = is_null($r->controller) ? $controller : $r->controller;
			$v = is_null($r->view) ? $action : $r->view;

			$vf = "views/$c/$v.php";

			if (!file_exists($vf)) {

				$vf = "views/shared/$v.php";

				if (!file_exists($vf)) {

					echo("View '$v' not found.");
					return;
				}
			}

			$model = $r->model;

			if ($r->layout) {

				$layout = self::$layout;
				$lf = "views/shared/$layout.php";
				if (!file_exists($lf)) {
					echo("Layout page '$layout' not found.");
					return;
				}

				$renderView = function() use ($vf, $model) {
					include $vf;
				};

				include $lf;
			}
			else
				include $vf;
		}
		elseif ($r instanceof JsonResult) {

			header("Content-type: application/json");
			echo json_encode($r->object);
		}
		elseif ($r instanceof ImageResult) {

			if (!is_null($r->type))
				header("Content-type: $r->type");

			echo $r->data;
		}
	}

	public static function buildUrl($action,
		$id=NULL,
		$controller=NULL) {
	
		return self::$baseDir . "/" .
				($controller == null ? self::$controller : $controller) .
				"/" . $action .
				($id != NULL ? '/' . $id : '');
	}

	public static function getContentUrl($path) {

		return self::$baseDir . "/" .
			self::$contentDir . "/" .
			$path;
	}
}

?>
