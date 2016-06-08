<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	class ActivationController extends Controller{

		public function init(){
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','public/ActivationView.php');
			$view->defSection('JAVASCRIPT','public/ActivationView.php');
			$view->defSection('MAIN_CONTENT','public/ActivationView.php');

			$view->setArg("PAGE_TITLE","Verify your email.");

			$this->setView($view);
		}

		public function run(){
			/*
				Output is "response-code" argument
				
				0  : All ok
				1  : Invalid token
				2  : Database Error

			 */

			if(!isset($this->params[1]) )
				$this->redirect("home");
			$token = $this->params[1];


			if( isset($_SESSION["ACCOUNT_ACTIVATED"]) )
			{
				$this->setArg("response-code" , 0);
				return;
			}

			$userMapper = new UserMapper();

			$userId = $userMapper->verifyEmailToken($token);

			if( !$userId ){

				$this->setArg("response-code" , 1);

			}else{

				$user = $userMapper->findById($userId);

				$user->setVerified(true);
				$user->setEmailVerificationToken(null);


				if( $user->getNewEmail() !== null){
					$user->setEmail( $user->getNewEmail() );
					$user->setNewEmail(null);
				}

				try{
					DatabaseConnection::getInstance()->startTransaction();

					$userMapper->persist($user);

					$this->setArg("response-code" , 0);
					$_SESSION["ACCOUNT_ACTIVATED"] = "yes";
					DatabaseConnection::getInstance()->commit();

				}catch(DatabaseException $ex){
					$this->setArg("response-code" , 2);
					DatabaseConnection::getInstance()->rollback();
				}



			}

		}

	}
