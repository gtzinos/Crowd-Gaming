<?php
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/QuestionGroupParticipationMapper.php';

	class RemoveUserFromQuestionGroupController extends Controller
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
				 1 : Invalid access
				 2 : Participation Doesnt exist
				 3 : General database error
				-1 : No post data;
			 */
			if( isset( $_POST["question-group-id"] , $_POST["user-id"]) )
			{
				$participationMapper = new ParticipationMapper;

				if( !($participationMapper->participatesInGroup($_SESSION["USER_ID"] , $_POST["question-group-id"] , 2)|| $_SESSION["USER_LEVEL"]==3) )
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				$groupParticipationMapper = new QuestionGroupParticipationMapper;


				$groupParticipation = $groupParticipationMapper->findParticipation( $_POST["user-id"] , $_POST["question-group-id"]);

				if( $groupParticipation === null)
				{
					$this->setOutput("response-code" , 2);
					return;
				}

				try
				{
					$groupParticipationMapper->delete($groupParticipation);

					$this->setOutput("response-code" , 0);
				}
				catch(DatabaseException $e)
				{

					$this->setOutput("response-code" , 3);
				}
				return;
			}

			$this->setOutput("response-code" , -1);

		}

	}