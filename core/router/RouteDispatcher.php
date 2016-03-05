<?php

	class RouteDispatcher{

		public function dispatch($uri){
			
			$params = explode("/" , $uri);

			/*
				Get the correct Controller
			 */
			$route["controller"] = Routes::get($params[0]);
			
			foreach ($params as $key => $value) {
				if( empty($value) )
					unset($params[$key]);
			}

			$route["parameters"] = $params;

			return $route;
		}


	}