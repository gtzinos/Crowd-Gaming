<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	class BanExaminersController extends Controller
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
				 1 : Database Error
				-1 : No post data
			 */
			if( isset( $_POST["questionnaire-id"]) )
			{
				
				try
				{	
					$userMapper = new UserMapper;
					$userMapper->banExaminersOfQuestionnaire($_POST["questionnaire-id"]);
				
					$this->setOutput("response-code" , 0);
				}
				catch(DatabaseException $e)
				{
					$this->setOutput("response-code" , 1);
				}

				return;
			}


			$this->setOutput("response-code" , -1);
		}
	}