<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../libs/htmlpurifier-4.7.0/HTMLPurifier.auto.php';

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
				3			: Message Required Error
				4			: Database Error
			 */
			
			if( isset( $_POST["name"] ,  $_POST["description"] , $_POST["message_required"] ) ){

				$name = htmlspecialchars($_POST["name"] , ENT_QUOTES);

				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($config);
				$description = $purifier->purify($_POST["description"]);

				$messageRequired = $_POST["message_required"];

				if( strlen($name) < 3 || strlen($name) > 40 ){
					
					$this->setArg('response-code',1); // Name Validation error

				}else if( strlen($description) < 30 ){
					
					$this->setArg('response-code',2); // Descriptin validation error

				}else if( $messageRequired != "no" && $messageRequired != "yes"){

					$this->setArg("response-code",3); // Message required error

				}else{

					$questionnaire = new Questionnaire;

					$questionnaire->setName( $name );
					$questionnaire->setDescription( $description );
					$questionnaire->setMessageRequired( $messageRequired=="yes" ? true : false );
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