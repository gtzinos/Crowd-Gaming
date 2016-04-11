<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../libs/htmlpurifier-4.7.0/HTMLPurifier.auto.php';

	class QuestionnaireEditController extends Controller{
		
		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','examiner/QuestionnaireEditView.php');
			$this->defSection('JAVASCRIPT','examiner/QuestionnaireEditView.php');
			$this->defSection('MAIN_CONTENT','examiner/QuestionnaireEditView.php');
			
		}

		public function run(){


			if( !isset( $this->params[1] ) ){
				$this->redirect("questionnaireslist");
			}


			$questionnaireMapper = new QuestionnaireMapper;
			$questionnaire = $questionnaireMapper->findById( $this->params[1] );

			if( $questionnaire === null || $questionnaire->getCoordinatorId() != $_SESSION["USER_ID"] ){
				$this->redirect("questionnaire/".$this->params[1]);
			}


			/*
				Response code values
				0			: Edited successfully
				1			: Name Validation error
				2			: Description Validation error
				3			: Message Required Error
				4			: Database Error
			 */
			if( isset( $_POST["name"] , $_POST["description"] , $_POST["message_required"] ) ){
				$name = htmlspecialchars($_POST["name"] , ENT_QUOTES);

				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($config);
				$description = $purifier->purify($_POST["description"]);

				$messageRequired = $_POST["message_required"];

				if( strlen($name) < 3 ){
					
					$this->setArg("response-code" , 1); // Name Validation error

				}else if( strlen($description) < 30 ){
					
					$this->setArg("response-code" , 2); // Descriptin validation error

				}else if( $messageRequired != "no" && $messageRequired != "yes"){

					$this->setArg("response-code" , 3); // Message required error

				}else{

					$questionnaire->setName( $name );
					$questionnaire->setDescription( $description );
					$questionnaire->setMessageRequired( $messageRequired=="yes" ? true : false );

					$questionnaireMapper = new QuestionnaireMapper;
					try{
						DatabaseConnection::getInstance()->startTransaction();


						$questionnaireMapper->persist($questionnaire);

						DatabaseConnection::getInstance()->commit();
						$this->setArg("response-code" , 0); // All ok

					}catch(DatabaseException $ex){
						
						DatabaseConnection::getInstance()->rollback();
						$this->setArg("response-code" , 4); // Database Error
					}
				}
			}


			$this->setArg("questionnaire" , $questionnaire);
		}

	}