<?php
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';

	class DeleteQuestionController extends Controller
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
				 4 Questionnaire is public , you cant delete it.
				-1 No Data
			 */
			if( isset( $_POST["question-id"] ) )
			{

				$participationMapper = new ParticipationMapper;
				$questionnaireMapper = new QuestionnaireMapper;

				if( !( $participationMapper->participatesInQuestion( $_SESSION["USER_ID"] , $_POST["question-id"] , 2 ) || $_SESSION["USER_LEVEL"]==3 ) )
				{

					$this->setOutput("response-code" , 2);
					return;
				}

				
				if( $questionnaireMapper->isQuestionPublic($_POST["question-id"]) && $_SESSION["USER_LEVEL"]!=3 )
				{
					// Invalid Access
					$this->setOutput('response-code' , 4);
					return;
				}

				$questionMapper = new QuestionMapper;
				$answerMapper = new AnswerMapper;
				$userAnswerMapper = new UserAnswerMapper;


				try
				{
					DatabaseConnection::getInstance()->startTransaction();

					$userAnswerMapper->deleteByQuestion( $_POST["question-id"] );
					$answerMapper->deleteByQuestion( $_POST["question-id"] );
					$questionMapper->deleteQuestionShownRecordsByQuestion($_POST["question-id"]);
					$questionMapper->deleteById( $_POST["question-id"]);

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