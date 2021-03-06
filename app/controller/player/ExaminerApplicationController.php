<?php
	include_once '../app/model/mappers/user/UserMapper.php';
	include_once '../app/model/mappers/actions/ExaminerApplicationMapper.php';

	class ExaminerApplicationController extends Controller{


		public function init(){
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','player/ExaminerApplicationView.php');
			$view->defSection('JAVASCRIPT','player/ExaminerApplicationView.php');
			$view->defSection('MAIN_CONTENT','player/ExaminerApplicationView.php');
			
			$view->setArg("PAGE_TITLE","Become an Examiner!");

			$this->setView($view);
		}

		public function run(){
			/*
				"response-code" Argument contains the result of execution
				not set : User can request to become an examiner
				0       : Application was created successfuly
				1		: User already examiner or moderator
				2       : User Must fill all informatino , eg address ,phone.
				3       : User has already an active application
				4		: ApplicationText validation error
				5       : General database error
			*/
			
			$userMapper = new UserMapper;
			$examinerApplicationMapper = new ExaminerApplicationMapper;

			$user = $userMapper->findById( $_SESSION["USER_ID"] );

			if( $user->getAccessLevel() != 1 ){

				$this->setArg("response-code" , 1);
			}else if( $user->getAddress() === null || $user->getPhone() === null ){

				$this->setArg("response-code" , 2); // User must fill all information
			}else if( $examinerApplicationMapper->hasActiveApplication($user->getId()) ){

				$this->setArg("response-code" , 3); // User has already an active application.
			}else if( isset( $_POST["application_text"]) ){
						
				$applicationText = htmlspecialchars($_POST["application_text"], ENT_QUOTES);

				if( strlen($applicationText) < 20 || strlen($applicationText)>255 ){

					$this->setArg("response-code" , 4);
				}else{
					
					$examinerApplication = new ExaminerApplication;
					$examinerApplication->setUserId( $user->getId() );
					$examinerApplication->setApplicationText( $applicationText );
					try{
						DatabaseConnection::getInstance()->startTransaction();
					}catch(DatabaseException $e){
						DatabaseConnection::getInstance()->rollback();
						$this->setArg("response-code" , 5); //General Database Error
					}
					$examinerApplicationMapper->persist($examinerApplication);
					DatabaseConnection::getInstance()->commit();
					$this->setArg("response-code" , 0); // can send a questionnaire
				}
			}	
			
		}

	}