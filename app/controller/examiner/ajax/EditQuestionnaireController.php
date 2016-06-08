<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../libs/htmlpurifier-4.7.0/HTMLPurifier.auto.php';

	class EditQuestionnaireController extends Controller{

		public function init(){
			$this->setView( new CodeView );
		}

		public function run(){

			/*
				Response code values
				0			: Edited successfully
				1			: Name Validation error
				2			: Description Validation error
				3			: Password Required Error
				4			: Database Error
				5			: Name already in use
				6			: User must be coordinator
			 */
			if( isset( $_POST["questionnaire-id"] ,$_POST["name"] , $_POST["description"] , $_POST["message_required"] ) ){
				$questionnaireMapper = new QuestionnaireMapper;

				$questionnaire = $questionnaireMapper->findById( $_POST["questionnaire-id"] );

				if( $questionnaire === null || !($questionnaire->getCoordinatorId() == $_SESSION["USER_ID"] || $_SESSION["USER_LEVEL"]==3) ){
					$this->setOutput("response-code" , 6);
				}


				$name = htmlspecialchars($_POST["name"] , ENT_QUOTES);
				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($config);
				$description = $purifier->purify($_POST["description"]);


				$messageRequired = $_POST["message_required"];

				$message = NULL;

				if( isset($_POST["message"]) && strlen($_POST["message"])<255)
				{
					$message = htmlspecialchars($_POST["message"]);
				}

				if( strlen($name) < 3 ){

					$this->setOutput("response-code" , 1); // Name Validation error
					return;
				}

				if( $questionnaire->getName()!=$name && $questionnaireMapper->nameExists( $name ) ){

					$this->setOutput("response-code" , 5);
					return;
				}

				if( strlen($description) < 30 ){

					$this->setOutput("response-code" , 2); // Descriptin validation error
					return;
				}

				if( $messageRequired != "no" && $messageRequired != "yes"){

					$this->setOutput("response-code" , 3); // Password required error
					return;
				}



				$questionnaire->setName( $name );
				$questionnaire->setDescription( $description );
				$questionnaire->setMessage( $message);
				$questionnaire->setMessageRequired( $messageRequired=="yes" ? true : false );


				try{
					DatabaseConnection::getInstance()->startTransaction();


					$questionnaireMapper->persist($questionnaire);
					DatabaseConnection::getInstance()->commit();
					$this->setOutput("response-code" , 0); // All ok

				}catch(DatabaseException $ex){

					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("response-code" , 4); // Database Error
				}

				return;
			}

			$this->setOutput("response-code", -1);

		}

	}
