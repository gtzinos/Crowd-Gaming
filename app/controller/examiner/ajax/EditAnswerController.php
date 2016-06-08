<?php

	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class EditAnswerController extends Controller{
		
		public function init(){
			$this->setView( new CodeView );
			
		}

		public function run(){

			/*
				Repsonse Status

				0  : All ok
				1  : Answer does not exist
				2  : You dont have permission
				3  : Answer does not belong to question
				4  : Answer text validation error
				5  : is-correct validation error
				6  : General Database Error
				-1 : No Data
			 */
			// disabled
			if( false && isset( $_POST["answer-id"] , $_POST["question-id"] , $_POST["answer-text"] , $_POST["is-correct"] ) ){

				$participationMapper = new ParticipationMapper;
				$answerMapper = new AnswerMapper;

				$answer = $answerMapper->findById($_POST["answer-id"] );

				if( $answer === null ){
					$this->setOutput('response-code' , 1);
					return;
				}



				if( !($participationMapper->participatesInQuestion( $_SESSION["USER_ID"] , $_POST["question-id"] , 2 ) || $_SESSION["USER_LEVEL"]==3 ) ){
					// Invalid Access
					$this->setOutput('response-code' , 2);
					return;
				}

				if( $answer->getQuestionId() != $_POST["question-id"] ){
					$this->setOutput( 'response-code' , 3);
					return;
				}

				if( strlen( $_POST["answer-text"] ) < 2 || strlen($_POST["answer-text"] ) >255 ){
					$this->setOutput('response-code' , 4);
					return;
				}

				if( $_POST["is-correct"] != "true" && $_POST["is-correct"] != "false" ){
					$this->setOutput('response-code' , 5);
					return;
				}

				$answer->setAnswerText( htmlspecialchars($_POST["answer-text"] , ENT_QUOTES) );
				$answer->setCorrect( $_POST["is-correct"] == "true" ? true : false );


				try{

					$answerMapper->persist($answer);

					$this->setOutput("response-code" , 0);
				}catch(DatabaseException $e){

					$this->setOutput("response-code" , 6);
				}

				return;
			}

			$this->setOutput("response-code" , -1);
		}

	}