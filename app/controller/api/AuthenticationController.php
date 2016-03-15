<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	class AuthenticationController extends Controller{
		
		public function init(){
			
		}

		public function run(){

			$response = array();
			if( !isset( $this->params[1]  ,$this->params[2])  ){
				$response["code"] = "404";
				$response["message"] = "Username or password or both were not given.";

				print json_encode($response);
				return;
			}

			$userMapper = new UserMapper;

			$user = $userMapper->authenticate( $this->params[1] , $this->params[2] );

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