<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/user/UserMapper.php';

	class DeleteQuestionnaireController extends Controller
	{
		
		public function init()
		{
			$this->setOutputType( OutputType::ResponseStatus );
			
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

					$answerMapper->deleteByQuestionnaire( $_POST["questionnaire-id"] );
					$questionMapper->deleteByQuestionnaire( $_POST["questionnaire-id"]);
					$questionGroupMapper->deleteByQuestionnaire( $_POST["questionnaire-id"]);
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