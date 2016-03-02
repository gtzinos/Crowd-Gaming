<?php
	include_once '../app/model/mappers/user/UserMapper.php';
	include_once '../app/model/mappers/actions/ExaminerApplicationMapper.php';

	class ExaminerApplicationController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/ExaminerApplicationView.php');
			$this->defSection('JAVASCRIPT','player/ExaminerApplicationView.php');
			$this->defSection('MAIN_CONTENT','player/ExaminerApplicationView.php');
			
		}

		public function run(){
			/*
				"error-code" Argument contains the result of execution
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

				$this->setArg("error-code" , 1);
			}else if( $user->getAddress() === null || $user->getPhone() === null ){

				$this->setArg("error-code" , 2); // User must fill all information
			}else if( $examinerApplicationMapper->hasActiveApplication($user->getId()) ){

				$this->setArg("error-code" , 3); // User has already an active application.
			}else if( isset( $_POST["application_text"]) ){
						
				$applicationText = htmlspecialchars($_POST["application_text"], ENT_QUOTES);

				if( strlen($applicationText) < 20 || strlen($applicationText)>255 ){

					$this->setArg("error-code" , 4);
				}else{
					
					$examinerApplication = new ExaminerApplication;
					$examinerApplication->setUserId( $user->getId() );
					$examinerApplication->setApplicationText( $applicationText );
					try{
						DatabaseConnection::getInstance()->startTransaction();
					}catch(DatabaseException $e){
						DatabaseConnection::getInstance()->rollback();
						$this->setArg("error-code" , 5); //General Database Error
					}
					$examinerApplicationMapper->persist($examinerApplication);
					DatabaseConnection::getInstance()->commit();
					$this->setArg("error-code" , 0); // can send a questionnaire
				}
			}	
			
		}

	}