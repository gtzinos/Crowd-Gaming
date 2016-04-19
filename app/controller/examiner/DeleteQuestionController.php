<?php
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

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
				-1 No Data
			 */
			if( isset( $_POST["question-id"] ) )
			{

				$participationMapper = new ParticipationMapper;

				if( !$participationMapper->participatesInQuestion( $_SESSION["USER_ID"] , $_POST["question-id"] , 2 ) )
				{

					$this->setOutput("response-code" , 2);
					return;
				}

				$questionMapper = new QuestionMapper;
				$answerMapper = new AnswerMapper;


				try
				{
					DatabaseConnection::getInstance()->startTransaction();

					$answerMapper->deleteByQuestion( $_POST["question-id"] );
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