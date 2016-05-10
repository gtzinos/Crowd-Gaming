<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	class AuthenticationController extends Controller
	{
		
		public function init()
		{
			
		}

		public function run()
		{
			$httpBody = file_get_contents('php://input');
			$parameters = json_decode($httpBody,true);


			$response = array();
			
			if( !isset( $parameters["email"]  ,$parameters["password"])  )
			{
				$response["code"] = "602";
				$response["message"] = "Username or password or both were not given.";
				http_response_code(400);
				print json_encode($response);
				return;
			}

			$userMapper = new UserMapper;

			$user = $userMapper->authenticate( $parameters["email"] , $parameters["password"] );

			if( is_object( $user ) )
			{

				$response["code"] = "200";
				$response["message"] = "Authorization Succeeded.";

				$response["user"]["name"] = $user->getName();
				$response["user"]["surname"] = $user->getSurname();
				$response["user"]["api-token"] = $user->getApiToken();

				
			}
			else
			{
				http_response_code(400);
				$response["code"] = "601";
				$response["message"] = "Username or password are wrong.";
			}

			print json_encode($response);
		}

	}