<?php
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class EditQuestionController extends Controller{
		
		public function init(){
			$this->setOutputType( OutputType::ResponseStatus );
			
		}

		public function run(){

			/*
				Response Code
				0 All ok
				1 Question does not exists
				2 You dont have permission
				3 question-text validation error
				4 time-to-answer validation error
				5 Multiplier validation error
				6 Database Error
			   -1 No data
			 */

			if( isset( $_POST["question-id"] , $_POST["question-text"] , $_POST["time-to-answer"] , $_POST["multiplier"] ) ){

				$participationMapper = new ParticipationMapper;
				$questionMapper = new QuestionMapper;

				$question = $questionMapper->findById($_POST["question-id"] );

				if( $question === null ){
					$this->setOutput('response-code' , 1);
					return;
				}

				if( !$participationMapper->participatesInQuestion( $_SESSION["USER_ID"] , $_POST["question-id"] , 2 ) ){
					// Invalid Access
					$this->setOutput('response-code' , 2);
					return;
				}

				if( strlen( $_POST["question-text"] ) < 2 || strlen($_POST["question-text"] ) >255 ){
					$this->setOutput('response-code' , 3);
					return;
				}

				if( !is_numeric($_POST["time-to-answer"]) || $_POST["time-to-answer"]<5 || $_POST["time-to-answer"] > 180 ){
					$this->setOutput('response-code' , 4);
					return;
				} 

				if( !is_numeric($_POST["multiplier"]) || $_POST["multiplier"] <= 0 ){
					$this->setOutput('response-code' , 5);
					return;
				}


				$question->setQuestionText( htmlspecialchars($_POST["question-text"] , ENT_QUOTES) );
				$question->setMultiplier( $_POST["multiplier"] );
				$question->setTimeToAnswer( $_POST["time-to-answer"] );

				try{

					
					$questionMapper->persist($question);

					$this->setOutput("response-code" , 0);
				}catch(DatabaseException $e){

					$this->setOutput("response-code" , 6);
				}

				return;

			}

			$this->setOutput("response-code" , -1);
		}

	}