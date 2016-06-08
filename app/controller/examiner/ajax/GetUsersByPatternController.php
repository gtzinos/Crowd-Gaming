<?php
	include '../app/model/mappers/user/UserMapper.php';

	class GetUsersByPatternController extends Controller
	{
		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{


			if( isset($_POST["pattern"]) )
			{

				$userMapper = new UserMapper;

				$users = $userMapper->findByPattern( $_POST["pattern"] ,10);
				$userCount = $userMapper->findCountByPattern( $_POST["pattern"]  );

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

				$this->setOutput("result-count" , $userCount );
				$this->setOutput("response_code",0);
				$this->setOutput("users" , $usersJson);
			}


		}
	}