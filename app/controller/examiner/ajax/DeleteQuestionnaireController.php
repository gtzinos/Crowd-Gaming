<?php
	include_once '../app/model/mappers/actions/PlaythroughMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireScheduleMapper.php';
	include_once '../app/model/mappers/user/UserMapper.php';
	include_once '../app/model/mappers/actions/QuestionGroupParticipationMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/RequestMapper.php';
	include_once '../app/model/mappers/user/UserReportMapper.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';

	class DeleteQuestionnaireController extends Controller
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
				 4 Cant delete an public questionnaire
				-1 No Data
			 */
			if( isset( $_POST["questionnaire-id"] , $_POST["password"] ) )
			{

				$userMapper = new UserMapper;

				if( $userMapper->authenticate( $_SESSION["USER_EMAIL"] , $_POST["password"] ) === null )
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				$questionMapper = new QuestionMapper;
				$answerMapper = new AnswerMapper;
				$questionGroupMapper = new QuestionGroupMapper;
				$questionnaireMapper = new QuestionnaireMapper;
				$userAnswerMapper = new UserAnswerMapper;
				$groupParticipationMapper = new QuestionGroupParticipationMapper;
				$participationMapper = new ParticipationMapper;
				$requestMapper = new RequestMapper;
				$scheduleMapper = new QuestionnaireScheduleMapper;
				$playthroughMapper = new PlaythroughMapper;
				$userReportMapper = new UserReportMapper;

				$questionnaire = $questionnaireMapper->findById( $_POST["questionnaire-id"] );

				if( $questionnaire === null || $questionnaire->getCoordinatorId() != $_SESSION["USER_ID"] )
				{
					$this->setOutput("response-code" , 2);
					return;
				}

				if ( $questionnaireMapper->isPublic($questionnaire->getId()) && $_SESSION["USER_LEVEL"]!=3 )
				{
					$this->setOutput("response-code" , 4);
					return;
				}
				

				try
				{
					DatabaseConnection::getInstance()->startTransaction();

					$userAnswerMapper->deleteByQuestionnaire( $_POST["questionnaire-id"] );
					$answerMapper->deleteByQuestionnaire( $_POST["questionnaire-id"] );
					$questionMapper->deleteQuestionShownRecordsByQuestionnaire( $_POST["questionnaire-id"]);
					$questionMapper->deleteByQuestionnaire( $_POST["questionnaire-id"]);
					$groupParticipationMapper->deleteByQuestionnaire( $_POST["questionnaire-id"] );
					$playthroughMapper->deleteAllPlaythroughs( $_POST["questionnaire-id"]);
					$questionGroupMapper->deleteByQuestionnaire( $_POST["questionnaire-id"]);
					$requestMapper->deleteByQuestionnaire( $_POST["questionnaire-id"]);
					$participationMapper->deleteByQuestionnaire( $_POST["questionnaire-id"]);
					$scheduleMapper->deleteByQuestionnaire($_POST["questionnaire-id"]);
					$userReportMapper->deleteByQuestionnaire($_POST["questionnaire-id"]);
					$questionnaireMapper->deleteById( $_POST["questionnaire-id"]);


					DatabaseConnection::getInstance()->commit();
					$this->setOutput("response-code" , 0); 

				}
				catch(DatabaseException $ex)
				{

					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("response-code" , 3);
				}

				return;
			}

			$this->setOutput("response-code" , -1);
		}

	}