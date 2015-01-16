<?php

class Mvcer {
	
	private static $controller, $action, $baseDir;
	
	public static $layout = "_layout";
	public static $contentDir = "content";
	public static $internalPrefix = "_";

	private static $handled = false;

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

		// get controller method
		self::$action = $action = $params[$idx] ? $params[$idx++] : $defaultAction;

		if (!is_null(self::$internalPrefix) &&
			strpos($action, self::$internalPrefix) === 0) {

			echo "Page not allowed";
			return;
		}

		$id = count($params) > 2 ? $params[$idx++] : NULL;

		self::renderAction(null, $id);
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

	public static function renderAction($action = null,
										$id = null,
										$controller = null) {

		if (is_null($controller)) $controller = self::$controller;
		if (is_null($action)) $action = self::$action;

		$cn = $controller . "Controller";
		
		if (!class_exists($cn)) {
			echo("No controller found for model '$controller'.");
			die();
		}
		
		// instantiate controller from string
		$c = new $cn;
		
		// get controller method
		if (!is_callable(array($c, $action))) {
		
			// todo: add error page functionality
			echo "page not found";
			return;
		}

		//$opts["id"] = $id;
		
		// prevent controller from outputting response
		//ob_start();
		
		try {

			// call controller method
			$r = call_user_func(array($c, $action), $id);

		} catch (exception $e) {

			$r = new ViewResult($e, "error");
		}
		
		// throw away any response
		//ob_end_clean();

		if (is_null($r)) return;

		//$activity = $r->getActivity();
		//if ($activity == Activity::VIEW) {
		if ($r instanceof ViewResult) {

			if (is_null($r->controller)) $r->controller = $controller;
			if (is_null($r->view)) $r->view = $action;

			self::renderViewResult($r);
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
		elseif ($r instanceof RedirectResult) {

			if (is_array($r->query)) {

				$q = "?";
				foreach ($r->query as $k => $v) {

					$q .= "$k=$v&";
				}
				$q = rtrim($q, "&");
			}

			$url = self::buildUrl($r->action,
								  $r->id,
								  is_null($r->controller) ? $controller : $r->controller)
				. $q;

			header("Location: $url");
		}
	}

	private static function renderViewResult(ViewResult $r) {

		$vf = "views/$r->controller/$r->view.php";

		if (!file_exists($vf)) {

			$vf = "views/shared/$r->view.php";

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

	public static function renderView($view,
									  $model = null,
									  $controller = null,
									  $layout = false) {

		self::renderViewResult(new ViewResult($model,
											  $view,
											  is_null($controller) ? self::$controller : $controller,
											  $layout));
	}

	public static function isPost() {

		return $_SERVER['REQUEST_METHOD'] === 'POST' && !self::$handled;
	}

	public static function postHandled() {

		self::$handled = true;
	}
}

?>
