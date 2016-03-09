<?php

	class Routes{
		private static $routes;


		public static function add($pattern , $controller, $userLevel){
			self::$routes[$pattern]["controller"] = $controller;
			self::$routes[$pattern]["user_level"] = $userLevel;
		}

		public static function get($controller){
			
			if(array_key_exists($controller, self::$routes) && self::$routes[$controller]["user_level"] <= $_SESSION["USER_LEVEL"]){
				$_SESSION["CURRENT_PAGE"] = $controller; 
				$route = self::$routes[$controller]["controller"];

				return $route;
			}else{
				global $_CONFIG;

				http_response_code(404);
				return self::get($_CONFIG["404_ROUTE"]);
			}
		
		}

		public static function getByRegex($url){

			foreach (self::$routes as $pattern => $controller) {
				if( preg_match( '/'.$pattern.'/', $url) ){
					return $controller["controller"];				
				}
			}

			global $_CONFIG;

			http_response_code(404);
			return self::getByRegex($_CONFIG["404_ROUTE"]);
		}


	}