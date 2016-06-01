<?php
	require_once dirname(__DIR__)."/libs/Twig/lib/Twig/Autoloader.php";
	Twig_Autoloader :: register();

	spl_autoload_register(function($class){
		$root = dirname(__DIR__);
		$file = $root.'/'.str_replace('\\', '/', $class).'.php';	
		
		if(is_readable($file)){
			require $root."/".str_replace('\\', '/', $class).'.php';
		}
	});
	error_reporting(E_ALL);
	//ini_set("display_errors", 1);
	set_error_handler("Core\Error::errorHandler");
	set_exception_handler("Core\Error::exceptionHandler");

	
	$router = new Core\Router();

	$router-> add("", ["controller" => "Home", "action" => "index"]);
	$router-> add("{controller}/{action}");
	$router-> add("{controller}/{id:\d+}/{action}");
	$router-> add("admin/{controller}/{action}", ["namespace" => "Admin"]);

	/*echo "<pre>";
	echo htmlspecialchars(print_r($router-> getRoutes(), true));
	echo "</pre>";

	$router-> match($_SERVER["QUERY_STRING"]);

	echo "<pre>";
	echo htmlspecialchars(print_r($router-> getParams(), true));
	echo "</pre>";*/

	$router-> dispatch($_SERVER["QUERY_STRING"]);
?> 