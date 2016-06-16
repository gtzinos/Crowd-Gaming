<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/QuestionGroupParticipationMapper.php';
	include_once '../app/model/mappers/actions/PlaythroughMapper.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';

	class DeleteQuestionGroupController extends Controller
	{
		
		public function init()
		{
			$this->setView( new CodeView );
		}

		public function run()
		{
			/*
				ResponseCode
				 0 All ok
				 1 Authentication failed
				 2 Access error
				 3 Database error
				 4 Questionnaire is public , you cant delete this.
				-1 No Data
			 */
			if( isset( $_POST["question-group-id"] ) )
			{

				$participationMapper = new ParticipationMapper;

				if( !($participationMapper->participatesInGroup( $_SESSION["USER_ID"] , $_POST["question-group-id"] , 2 ) || $_SESSION["USER_LEVEL"]==3))
				{

					$this->setOutput("response-code" , 2);
					return;
				}

				$questionMapper = new QuestionMapper;
				$answerMapper = new AnswerMapper;
				$questionGroupMapper = new QuestionGroupMapper;
				$questionnaireMapper = new QuestionnaireMapper;
				$userAnswerMapper = new UserAnswerMapper;
				$groupParticipationMapper = new QuestionGroupParticipationMapper;
				$playthroughMapper = new PlaythroughMapper;

				if ( $questionnaireMapper->isGroupPublic($_POST["question-group-id"]) && $_SESSION["USER_LEVEL"]!=3 )
				{
					$this->setOutput("response-code" , 4);
					return;
				}

				try
				{
					DatabaseConnection::getInstance()->startTransaction();

					$userAnswerMapper->deleteByGroup( $_POST["question-group-id"] );
					$answerMapper->deleteByGroup( $_POST["question-group-id"] );
					$questionMapper->deleteQuestionShownRecordsByGroup( $_POST["question-group-id"] );
					$questionMapper->deleteByGroup( $_POST["question-group-id"]);
					$groupParticipationMapper->deleteByGroup( $_POST["question-group-id"] );
					$playthroughMapper->deletePlaythroughByGroup( $_POST["question-group-id"]);
					$questionGroupMapper->deleteById( $_POST["question-group-id"]);

					DatabaseConnection::getInstance()->commit();
					$this->setOutput("response-code" , 0); 

				}catch(DatabaseException $ex)
				{
					//print $ex->getMessage();
					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("response-code" , 3);
				}

				return;
			}

			$this->setOutput("response-code" , -1);
		}

	}