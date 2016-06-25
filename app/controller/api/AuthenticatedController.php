<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	abstract class AuthenticatedController extends Controller
	{
		private $userLevel;

		protected function authenticateToken()
		{

			// If is called by the website , no need to authenticate by header.
			if( isset( $_SESSION["USER_ID"] ) )
			{
				$this->userLevel = $_SESSION["USER_LEVEL"];
				return $_SESSION["USER_ID"];
			}

			$headers = getallheaders();

			/*
				Check if the Autherization is set and compare it with the values in the db
			 */
			if( isset( $headers["Authorization"]) )
			{

				$userMapper = new UserMapper;

				$user = $userMapper->authenticateByToken($headers["Authorization"]);

				if(is_object($user))
				{
					$this->userLevel = $user->getAccessLevel();
					return $user->getId();
				}
			}

			/*
				Token not found, send 403.
			 */
			http_response_code(403);
			$response["code"] = "403";
			$response["message"] = "Unauthorised access";

			print json_encode($response);
			die();
		}

		protected function getUserLevel()
		{
			return $this->userLevel;
		}

		protected function getCoordinates()
		{
			$headers = getallheaders();

			if( isset( $headers["X-Coordinates"] ) )
			{
				$args = explode( ";" ,$headers["X-Coordinates"]  );

				$coordinates["latitude"] = $args[0];
				$coordinates["longitude"] = $args[1];
				return $coordinates;
			}
			return null;
		}


	}