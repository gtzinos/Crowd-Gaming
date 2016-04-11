<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../libs/htmlpurifier-4.7.0/HTMLPurifier.auto.php';

	class QuestionnaireGroupsController extends Controller{

    public function init(){
      global $_CONFIG;

      $this->setTemplate($_CONFIG["BASE_TEMPLATE"]);
			$this->defSection('CSS','examiner/QuestionnaireGroupsView.php');
			$this->defSection('JAVASCRIPT','examiner/QuestionnaireGroupsView.php');
      $this->defSection('MAIN_CONTENT','examiner/QuestionnaireGroupsView.php');

    }

		public function run(){

			/*
				Response Codes (Ajax)
				not set 	: User didnt request questionnaire creation
				0			: Created successfully
				1			: Name Validation error
				2			: Description Validation error
				3			: Message Required Error
				4			: Database Error
			 */
			if( isset($_POST["name"] ,  $_POST["description"] , $_POST["message_required"] ) ){

				$name = htmlspecialchars($_POST["name"] , ENT_QUOTES);
				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($config);
				$description = $purifier->purify($_POST["description"]);

				$messageRequired = $_POST["message_required"];

				if( strlen($name) < 3 ){

					print 1; // Name Validation error

				}else if( strlen($description) < 30 ){

					print 2; // Descriptin validation error

				}else if( $messageRequired != "no" && $messageRequired != "yes"){

					print 3; // Message required error

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
						print 0; // All ok

					}catch(DatabaseException $ex){

						DatabaseConnection::getInstance()->rollback();
						print 4; // Database Error
					}
				}
			}


		}

	}
