<?php
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/user/UserMapper.php';


	class GetUsersFromQuestionGroupController extends Controller
	{

		public function init()
		{
			$this->setOutputType( OutputType::JsonView );
		}

		public function run()
		{

			/*
				 Response Codes
				 0 : All ok
				 1 : Invalid Access
				-1 : Not Post Data
			 */
			if( isset( $_POST["question-group-id"]) )
			{
				$participationMapper = new ParticipationMapper;

				if( !$participationMapper->participatesInGroup($_SESSION["USER_ID"] , $_POST["question-group-id"] , 2) )
				{
					$this->setOutput("response_code" , 1);
					return;
				}

				$userMapper = new UserMapper;


				$users = $userMapper->findUsersByQuestionGroup( $_POST["question-group-id"]);


				$usersJson = array();
				foreach ($users as $user) 
				{
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

				return;
			}

			$this->setOutput("response_code" , -1);

		}

	}
