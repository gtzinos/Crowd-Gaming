<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	class GetAvailableCoordinatorsController extends Controller
	{
		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{


			if( $_POST["questionnaire-id"] )
			{

				$userMapper = new UserMapper;

				$users = $userMapper->findAvailableCoordinators($_POST["questionnaire-id"]);

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
			}
		}
	}