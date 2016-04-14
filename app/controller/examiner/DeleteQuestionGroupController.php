<?php
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/user/UserMapper.php';

	class DeleteQuestionGroupController extends Controller{
		
		public function init(){
			$this->setOutputType( OutputType::ResponseCode );
			
		}

		public function run(){
			/*
				ResponseCode
				 0 All ok
				 1 Authentication failed
				 2 Access error
				 3 Database error
				-1 No Data
			 */
			if( isset( $_POST["question-group-id"] , $_POST["password"] ) ){

				$userMapper = new UserMapper;

				if( $userMapper->authenticate( $_SESSION["USER_EMAIL"] , $_POST["password"] ) === null ){
					
					$this->setOutput("response-code" , 1);
					return;
				}

				$participationMapper = new ParticipationMapper;

				if( !$participationMapper->participatesInGroup( $_SESSION["USER_ID"] , $_POST["question-group-id"] , 2 ) ){

					$this->setOutput("response-code" , 2);
					return;
				}

				$questionMapper = new QuestionMapper;
				$answerMapper = new AnswerMapper;
				$questionGroupMapper = new QuestionGroupMapper;

				try{
					DatabaseConnection::getInstance()->startTransaction();

					$answerMapper->deleteByGroup( $_POST["question-group-id"] );
					$questionMapper->deleteByGroup( $_POST["question-group-id"]);
					$questionGroupMapper->deleteById( $_POST["question-group-id"]);

					DatabaseConnection::getInstance()->commit();
					$this->setOutput("response-code" , 0); 

				}catch(DatabaseException $ex){

					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("response-code" , 3);
				}

				return;
			}

			$this->setOutput("response-code" , -1);
		}

	}