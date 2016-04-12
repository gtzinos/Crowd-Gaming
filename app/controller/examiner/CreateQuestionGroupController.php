<?php
	include_once "../app/model/mappers/questionnaire/QuestionGroupMapper.php";
	include_once "../app/model/mappers/actions/ParticipationMapper.php";


	class CreateQuestionGroupController extends Controller{

		public function init(){
			$this->setOutputType( OutputType::ResponseStatus );

		}

		public function run(){
			/*
				Response Code
				0 All ok
				1 Invalid Access
				2 Group name validation error
				3 latitude validation error
				4 longitude validation error
				5 radius validation error
				6 Database error
			   -1 No data
			 */

			if( isset( $_POST["questionnaire-id"] , $_POST["name"] , $_POST["latitude"] , $_POST["longitude"] , $_POST["radius"] ) ){

				$participationMapper = new ParticipationMapper;

				if( !$participationMapper->participates( $_SESSION["USER_ID"] , $_POST["questionnaire-id"] , 2 ) ){
					// Invalid Access
					$this->setOutput('response-code' , 1);
					return;
				}

				if( strlen( $_POST["name"] ) < 2 || strlen($_POST["name"] ) >255 ){
					$this->setOutput('response-code' , 2);
					return;
				}

				if( !is_numeric($_POST["latitude"]) || $_POST["latitude"]< -90 || $_POST["latitude"] > 90 ){
					$this->setOutput('response-code' , 3);
					return;
				} 

				if( !is_numeric($_POST["longitude"]) || $_POST["longitude"]< -180 || $_POST["longitude"] > 180 ){
					$this->setOutput('response-code' , 4);
					return;
				} 

				if( !is_numeric($_POST["radius"]) || $_POST["longitude"]< 5 ){
					$this->setOutput('response-code' , 5);
					return;
				} 


				$questionGroup = new QuestionGroup;

				$questionGroup->setName( htmlspecialchars($_POST["name"] ,ENT_QUOTES) );
				$questionGroup->setQuestionnaireId( $_POST["questionnaire-id"] );
				$questionGroup->setLatitude( $_POST["latitude"] );
				$questionGroup->setLongitude( $_POST["longitude"] );
				$questionGroup->setRadius( $_POST["radius"] );

				try{

					$questionGroupMapper = new QuestionGroupMapper;

					$questionGroupMapper->persist($questionGroup);


					$this->setOutput("response-code" , 0);
				}catch(DatabaseException $e){

					$this->setOutput("response-code" , 6);
				}

				return;

			}

			$this->setOutput("response-code" , -1);
		}

	}
