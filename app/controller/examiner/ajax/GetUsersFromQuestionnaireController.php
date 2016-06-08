<?php
	include_once '../app/model/mappers/user/UserMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';

	class GetUsersFromQuestionnaireController extends Controller
	{
		
		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{
			
			/*
				Response Codes
				0 all ok
				1 Questionnaires doesnt exist
				2 You dont have access
			 */
			if( isset($_POST["questionnaire-id"]) )
			{
				$questionnaireMapper = new QuestionnaireMapper;

				$questionnaire = $questionnaireMapper->findById( $_POST["questionnaire-id"] );

				if( $questionnaire === null )
				{
					$this->setOutput("response_code" , 1);
					return;
				}

				if( !( $questionnaire->getCoordinatorId() == $_SESSION["USER_ID"]  || $_SESSION["USER_LEVEL"] ==3 ) )
				{
					$this->setOutput("response_code" , 2);
					return;
				}

				$userMapper = new UserMapper;

				$users = $userMapper->findUsersByQuestionnaire( $questionnaire->getId() ,1 );

				$usersJson = array();
				foreach ($users as $user) 
				{
					$arrayItem["access_level"] = $user->getAccessLevel();
					$arrayItem["id"] = $user->getId();
					$arrayItem["name"] = $user->getName();
					$arrayItem["surname"] = $user->getSurname();
					$arrayItem["email"] = $user->getEmail();
					$arrayItem["gender"] = $user->getGender() == 0 ? "male" : "female";
					$arrayItem["country"] = $user->getCountry();
					$arrayItem["city"] = $user->getCity();
					$arrayItem["address"] = $user->getAddress();
					$arrayItem["phone"] = $user->getPhone(); 

					$usersJson[] = $arrayItem;
				}

				$this->setOutput("response_code",0);
				$this->setOutput("users" , $usersJson);

			}

		}

	}