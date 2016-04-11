<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	class AuthenticationController extends Controller{
		
		public function init(){
			
		}

		public function run(){
			$httpBody = file_get_contents('php://input');
			$parameters = json_decode($httpBody,true);

			$response = array();
			
			if( !isset( $parameters["email"]  ,$parameters["password"])  ){
				$response["code"] = "404";
				$response["message"] = "Username or password or both were not given.";

				print json_encode($response);
				return;
			}

			$userMapper = new UserMapper;

			$user = $userMapper->authenticate( $parameters["email"] , $parameters["password"] );

			if( is_object( $user ) ){

				$response["code"] = "401";
				$response["message"] = "Authorization Succeeded.";

				$response["user"]["name"] = $user->getName();
				$response["user"]["surname"] = $user->getSurname();
				$response["user"]["api-token"] = $user->getApiToken();

				
			}else{

				$response["code"] = "401";
				$response["message"] = "Username or password are wrong.";
			}

			print json_encode($response);
		}

	}