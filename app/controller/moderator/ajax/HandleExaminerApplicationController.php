<?php

	include_once '../app/model/mappers/user/UserMapper.php';
	include_once '../app/model/mappers/actions/ExaminerApplicationMapper.php';

	class HandleExaminerApplicationController extends Controller
	{
		
		public function init()
		{
			$this->setOutputType( OutputType::ResponseStatus );			
		}

		public function run()
		{
			/*
				Response Code

				 0 : All ok
				 1 : Application does not exists
				 2 : Application already handled
				 3 : response can be either "accept" or "decline"
				 4 : General Database Error
				-1 : No data
			 */
			if( isset( $_POST["application-id"] , $_POST["response"]) )
			{
				$applicationMapper = new ExaminerApplicationMapper;

				$application = $applicationMapper->findById($_POST["application-id"]);

				if( $application === null)
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				if( $application->isAccepted() !== null )
				{
					$this->setOutput("response-code" , 2);
					return;
				}


				if( $_POST["response"] != "accept" && $_POST["response"] != "decline")
				{
					$this->setOutput("response-code" , 3);
					return;
				}

				$application->setAccepted( $_POST["response"] == "accept" ? true : false );

				try
				{
					DatabaseConnection::getInstance()->startTransaction();

					$applicationMapper->persist($application);

					if( $application->isAccepted() )
					{
						$userMapper = new UserMapper;
						
						$user = $userMapper->findById( $application->getUserId());

						$user->setAccessLevel(2);

						$userMapper->persist($user);
					}

					DatabaseConnection::getInstance()->commit();
					$this->setOutput("response-code" , 0);
				}
				catch( DatabaseException $e)
				{
					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("response-code" , 4);
				}

				return;
			}		

			$this->setOutput("response-code" , -1);
		}

	} 
