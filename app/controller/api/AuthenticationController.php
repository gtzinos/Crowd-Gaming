<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	class AuthenticationController extends Controller
	{
		
		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{
			$httpBody = file_get_contents('php://input');
			$parameters = json_decode($httpBody,true);


			
			if( !isset( $parameters["email"]  ,$parameters["password"])  )
			{
				$this->setOutput("code", "602");
				$this->setOutput("message", "Username or password or both were not given.");
				http_response_code(400);

				return;
			}

			$userMapper = new UserMapper;

			$user = $userMapper->authenticate( $parameters["email"] , $parameters["password"] );

			if( is_object( $user ) )
			{

				$this->setOutput("code" , "200" );
				$this->setOutput("message" , "Authorization Succeeded.");

				$jsonObject["name"] = $user->getName();
				$jsonObject["surname"] = $user->getSurname();
				$jsonObject["api-token"] = $user->getApiToken();

				$this->setOutput("user" , $jsonObject);
			}
			else
			{
				http_response_code(400);
				$this->setOutput("code" , "601");
				$this->setOutput("message" , "Username or password are wrong.");
			}

		}

	}