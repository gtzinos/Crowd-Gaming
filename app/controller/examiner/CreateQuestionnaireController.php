<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';

	class CreateQuestionnaireController extends Controller{
		
		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','examiner/CreateQuestionnaireView.php');
			$this->defSection('JAVASCRIPT','examiner/CreateQuestionnaireView.php');
			$this->defSection('MAIN_CONTENT','examiner/CreateQuestionnaireView.php');
			
		}

		public function run(){

			/*
				Response Codes
				not set 	: User didnt request questionnaire creation
				0			: Created successfully
				1			: Name Validation error
				2			: Description Validation error
				3			: Language Validation error
				4			: Database Error
			 */
			
			if( isset( $_POST["name"] ,  $_POST["description"] , $_POST["language"] ) ){

				$name = htmlspecialchars($_POST["name"] , ENT_QUOTES);
				$description = htmlspecialchars($_POST["description"] , ENT_QUOTES);
				$language = htmlspecialchars($_POST["language"] , ENT_QUOTES);

				if( strlen($name) < 3 || strlen($name) > 40 ){
					
					$this->setArg('response-code',1); // Name Validation error

				}else if( strlen($description) < 10 || strlen($description) > 255 ){
					
					$this->setArg('response-code',2); // Descriptin validation error

				}else if( strlen($language) < 3 || strlen($language) > 20 ){
					
					$this->setArg('response-code',3); // Language validation error

				}else{

					$questionnaire = new Questionnaire;

					$questionnaire->setName( $name );
					$questionnaire->setDescription( $description );
					$questionnaire->setLanguage( $language );
					$questionnaire->setPublic( false );
					$questionnaire->setCoordinatorId( $_SESSION["USER_ID"] );


					$questionnaireMapper = new QuestionnaireMapper;

					try{
						DatabaseConnection::getInstance()->startTransaction();


						$questionnaireMapper->persist($questionnaire);

						DatabaseConnection::getInstance()->commit();
						$this->setArg('response-code' , 0); // All ok

					}catch(DatabaseException $ex){
						
						DatabaseConnection::getInstance()->rollback();
						$this->setArg('response-code' , 4); // Database Error
					}
				}
			}


		}

	}