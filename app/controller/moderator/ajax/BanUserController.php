<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	class BanUserController extends Controller
	{
		public function init()
		{
			$this->setView( new CodeView );
		}

		public function run()
		{

			/*
				Response Codes
				 0 : All ok
				 1 : Users doesnt exist
				 2 : Database Error
				 3 : Invalid action-type
				 4 : Cant ban a moderator
				 5 : If action is ban means the user is already banned, the opposite if the action is unban.
				-1 : No post data
			 */
			if( isset( $_POST["user-id"] , $_POST["action-type"]) )
			{
				$userMapper = new UserMapper;

				$user = $userMapper->findById($_POST["user-id"]);

				if( $user === null )
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				if( $_POST["action-type"] != "ban" && $_POST["action-type"] != "unban" )
				{
					$this->setOutput("response-code" , 3);
					return;
				}

				if( $user->getAccessLevel() == 3)
				{
					$this->setOutput("response-code" , 4);
					return;
				}

				if( ( $_POST["action-type"]=="ban" && $user->getBanned() ) ||
				    ( $_POST["action-type"]=="unban" && !$user->getBanned() ) )
				{
					$this->setOutput("response-code" , 5);
					return;
				}

				$user->setBanned( $_POST["action-type"] == "ban");

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
