<?php
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/QuestionGroupParticipationMapper.php';

	class AddUserToQuestionGroupController extends Controller
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
				 1 : Invalid access
				 2 : User already participates to that question group
				 3 : User doesnt participate to this questionnaire
				 4 : General database error
				-1 : No post data;
			 */
			if( isset( $_POST["question-group-id"] , $_POST["user-id"]) )
			{
				$participationMapper = new ParticipationMapper;

				if( ! ( $participationMapper->participatesInGroup($_SESSION["USER_ID"] , $_POST["question-group-id"] , 2) || $_SESSION["USER_LEVEL"]==3) )
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				if( !$participationMapper->participatesInGroup($_POST["user-id"] , $_POST["question-group-id"] , 1) )
				{
					$this->setOutput("response-code" , 3);
					return;
				}

				$groupParticipationMapper = new QuestionGroupParticipationMapper;

				if( $groupParticipationMapper->participates($_POST["user-id"] , $_POST["question-group-id"]) )
				{
					$this->setOutput("response-code" , 2);
					return;
				}

				$groupParticipation = new QuestionGroupParticipation;

				$groupParticipation->setQuestionGroupId($_POST["question-group-id"]);
				$groupParticipation->setUserId( $_POST["user-id"] );


				try
				{
					$groupParticipationMapper->persist($groupParticipation);

					$this->setOutput("response-code" , 0);
				}
				catch(DatabaseException $e)
				{

					$this->setOutput("response-code" , 4);
				}
				return;
			}

			$this->setOutput("response-code" , -1);

		}

	}