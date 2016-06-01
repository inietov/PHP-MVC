<?php
	namespace Core;

	class Router{
		protected $routes = array();
		protected $params = array();

		public function add($route, $params = []){
			$route = preg_replace('/\//', '\\/', $route);
			$route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
			$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
			$route = '/^' . $route . '$/i';

			$this-> routes[$route] = $params;
		}

		public function getRoutes(){
			return $this-> routes;
		}

		public function match($url){
			$url = $this-> removeQueryParameters($url);

			foreach ($this-> routes as $route => $params) {
				if(preg_match($route, $url, $matches)){
					foreach ($matches as $key => $match) {
						if(is_string($key)){
							$params[$key] = $match;
						}
					}	
					$this-> params = $params;
					return true;
				}
			}
			return false;
		}

		public function getParams(){
			return $this-> params;
		}

		public function dispatch($url){
			if($this-> match($url)){
				$controller = $this-> params["controller"];
				$controller = $this-> convertFirstCaps($controller);
				//$controller = "\App\Controllers\\$controller";
				$controller = $this-> getNamespace().$controller;

				if(class_exists($controller)){
					$controller_obj = new $controller($this-> params);

					$action = $this-> params["action"];
					$action = $this-> convertCamelCase($action);

					if(is_callable([$controller_obj, $action])){
						$controller_obj-> $action();
					} else {
						throw new \Exception("Método $action (en Controller $controller) no encontrado");
					}
				} else {
					throw new \Exception("Clase $controller no encontrada");
				} 
			} else {
				throw new \Exception("No hay ruta");
			}
		}

		protected function convertFirstCaps($string){
			return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
		}

		protected function convertCamelCase($string){
			return lcfirst($this-> convertFirstCaps($string));
		}

		protected function removeQueryParameters($url){
			if ($url != ''){
				$parts = explode('&', $url, 2);

				if(strpos($parts[0], '=') === false){
					$url = $parts[0];
				} else {
					$url = '';
				}
			}
			return $url;
		}

		protected function getNamespace(){
			$namespace = "App\Controllers\\";

			if(array_key_exists("namespace", $this-> params)){
				$namespace .= $this-> params["namespace"]."\\";
			}

			return $namespace;
		}
	}
?>