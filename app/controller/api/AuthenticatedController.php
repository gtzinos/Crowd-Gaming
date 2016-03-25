<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	abstract class AuthenticatedController extends Controller{
		
		protected function authenticateToken(){
			$headers = getallheaders();

			/*
				Check if the Autherization is set and compare it with the values in the db
			 */
			if( isset( $headers["Authorization"]) ){

				$userMapper = new UserMapper;

				$user = $userMapper->authenticateByToken($headers["Authorization"]);

				if(is_object($user)){
					return $user->getId();
				}
			}

			/*
				Token not found, send 403.
			 */
			http_response_code(401);
			$response["code"] = "401";
			$response["message"] = "Unauthorised access";

			print json_encode($response);
			die();
		}

		protected function getCoordinates(){
			$headers = getallheaders();

			if( isset( $headers["X-Coordinates"] ) ){
				$args = explode( ";" ,$headers["X-Coordinates"]  );

				$coordinates["latitude"] = $args[0];
				$coordinates["longitude"] = $args[1];
				return $coordinates;
			}
			return null;
		}
	}