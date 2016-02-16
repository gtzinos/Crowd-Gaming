<?php

	class RouteDispatcher{

		public function dispatch($uri){
			
			$params = explode("/" , $uri);

			/*
				Get the correct Controller
			 */
			$route["controller"] = Routes::get($params[0]);
			$route["parameters"] = $params;

			return $route;
		}


	}