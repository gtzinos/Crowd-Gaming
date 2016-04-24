<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	class BanUserController extends Controller
	{
		public function init()
		{
			$this->setOutputType( OutputType::ResponseStatus );
		}

		public function run()
		{

			/*
				Response Codes
				 0 : All ok
				 1 : Users doesnt exist
				 2 : 

				-1 : No post data
			 */
			if( isset( $_POST["user-id"]) )
			{
				$userMapper = new UserMapper;

				$user = $userMapper->findById($_POST["user-id"]);

				if( $user === null )
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				$user->setBanned(true);

				try
				{

					$userMapper->persist($user);
				
					$this->setOutput("response-code" , 0);
				}
				catch(DatabaseException $e)
				{
					$this->setOutput("response-code" , 2);
				}

				return;
			}


			$this->setOutput("response-code" , -1);
		}
	}