<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	abstract class AuthenticatedController extends Controller{
		
		protected function authenticateToken(){
			return 2;
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
	}