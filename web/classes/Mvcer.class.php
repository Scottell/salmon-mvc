<?php

class Mvcer {
	
	private static $_model, $_view, $_base;
	
	public static $layout = "_layout";

	public static function run($defaultModel = NULL, $defaultView = "index") {
		
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
		self::$_base = dirname($_SERVER['PHP_SELF']);
		
		// get controller
		self::$_model = $_model = $params[$idx] ?  $params[$idx++] : $defaultModel;
		$cn = $_model . "Controller";
		
		if (!class_exists($cn)) {
			echo("No controller found for model '$_model'.");
			die();
		}
		
		// instantiate controller from string
		$c = new $cn;
		
		// get controller method
		self::$_view = $_view = $params[$idx] ? $params[$idx++] : $defaultView;
		if (!is_callable(array($c, $_view))) {
		
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
			$r = call_user_func(array($c, $_view), $id);

		} catch (exception $e) {

			$r = new Result(Activity::SHARED, null, false, "error");
		}
		
		// throw away any response
		//ob_end_clean();
		
		if (is_null($r)) return;

		if ($r->getActivity() == Activity::VIEW) {

			$vf = "views/$_model/$_view.php";
			if (!file_exists($vf)) {
				echo("View '$_view' not found for model '$_model'.");
				return;
			}

			self::renderView($vf,
				$r->getUseLayout(),
				$r->getSubject());
		}
		elseif ($r->getActivity() == Activity::JSON) {

			header("Content-type: application/json");
			echo json_encode($r->getSubject());
		}
		elseif ($r->getActivity() == Activity::SHARED) {

			$share = $r->getView();

			if (is_null($share))
				$share = $_view;

			$vf = "views/shared/$share.php";
			if (!file_exists($vf)) {
				echo("Shared view '$share' not found.");
				return;
			}
			
			self::renderView($vf,
				$r->getUseLayout(),
				$r->getSubject());
		}
	}

	private static function renderView($path, $useLayout, $model) {

		if ($useLayout) {

			$layout = self::$layout;
			$lf = "views/shared/$layout.php";
			if (!file_exists($lf)) {
				echo("Layout page '$layout' not found.");
				return;
			}

			$renderView = function() use ($path, $model) {
				include $path;
			};

			include $lf;
		}
		else
			include $path;
	}
	
	public static function buildUrl($action, $id=-1) {
	
		return self::$_base . "/" .
				self::$_model . "/" . 
				$action . 
				($id > -1 ? '/' . $id : '');
	}
}

?>
