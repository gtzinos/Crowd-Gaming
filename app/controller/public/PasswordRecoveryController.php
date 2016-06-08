<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	class PasswordRecoveryController extends Controller{

		public function init(){
			global $_CONFIG;
			/*
				Invalid activation link
			*/
			if(!isset($this->params[1]) || $this->params[1] == "")
			{
				$this->redirect("home");
			}

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','public/PasswordRecoveryView.php');
			$view->defSection('JAVASCRIPT','public/PasswordRecoveryView.php');
			$view->defSection('MAIN_CONTENT','public/PasswordRecoveryView.php');
			
			$view->setArg("PAGE_TITLE","Recover your Password");

			$this->setView($view);
		}

		public function run(){
			/*
				Response Code
				not set : The user has not requested yet to change password.
				0 		: all ok , password was reset
				1 		: Password validation error
				2 		: Database Error
			 */

			if( isset($_SESSION["USER_ID"]) || !isset($this->params[1]))
				$this->redirect("");

			if ( isset( $_POST["password"]) ){

				$password = $_POST["password"];

				if( strlen($password) < 8 ){

					$this->setArg("response-code" , 1); // Password validation error
				}else{

					$userMapper = new UserMapper;

					$userId = $userMapper->verifyPasswordToken($this->params[1]);

					if( $userId > 0 ){

						$user = $userMapper->findById($userId);

						$user->setPassword( password_hash( $password , PASSWORD_DEFAULT) );
						$user->setPasswordRecoveryToken(null);

						try{
							DatabaseConnection::getInstance()->startTransaction();

							$userMapper->persist($user);

							DatabaseConnection::getInstance()->commit();
							$this->setArg("response-code" , 0); // All ok
			 			}catch(DatabaseException $ex){
							DatabaseConnection::getInstance()->rollback();
							$this->setArg("response-code" , 2); // Database Error
						}
					}
					/*
						Invalid activation link
					*/
					else
					{
						$this->redirect("");
					}
				}
			}

		}

	}
