<?php
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/QuestionGroupParticipationMapper.php';


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

				$groupParticipationMapper = new QuestionGroupParticipationMapper;


				$groupParticipations = $groupParticipationMapper->findByGroup( $_POST["question-group-id"]);


				$usersJson = array();

				foreach ($groupParticipations as $groupParticipation) {
					$usersJson[] = $groupParticipation->getUserId();
				}

				$this->setOutput("response_code" , 0);
				$this->setOutput("users" , $usersJson);

				return;
			}

			$this->setOutput("response_code" , -1);

		}

	}
