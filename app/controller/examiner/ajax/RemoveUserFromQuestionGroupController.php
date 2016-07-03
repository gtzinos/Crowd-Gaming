<?php
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/QuestionGroupParticipationMapper.php';
	include_once '../app/model/mappers/actions/PlaythroughMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';

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

				$playthroughMapper = new PlaythroughMapper;
				$questionGroupMapper = new QuestionGroupMapper;

				$questionGroup = $questionGroupMapper->findById($_POST["question-group-id"]);

				try
				{
					DatabaseConnection::getInstance()->startTransaction();

					$groupParticipationMapper->delete($groupParticipation);
					$playthroughMapper->removePlaythrough($_POST["user-id"] , $_POST["question-group-id"]);

					if( $groupParticipationMapper->findCount($_POST["question-group-id"]) == 0 )
						$playthroughMapper->initPlaythroughForGroup( $questionGroup->getQuestionnaireId() ,$_POST["question-group-id"]);

					

					$this->setOutput("response-code" , 0);

					DatabaseConnection::getInstance()->commit();
				}
				catch(DatabaseException $e)
				{
					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("response-code" , 3);
				}
				return;
			}

			$this->setOutput("response-code" , -1);

		}

	}