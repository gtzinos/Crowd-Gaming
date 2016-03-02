<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	class ActivationController extends Controller{
		
		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','public/ActivationView.php');
			$this->defSection('JAVASCRIPT','public/ActivationView.php');
			$this->defSection('MAIN_CONTENT','public/ActivationView.php');
			
		}

		public function run(){

			if(!isset($this->params[1]) )
				$this->redirect("home");
			$token = $this->params[1];

			$userMapper = new UserMapper();

			$userId = $userMapper->verifyEmailToken($token);

			if( !$userId ){

				$this->setArg("error-code" , 1);

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

					$this->setArg("error-code" , 0);

					DatabaseConnection::getInstance()->commit();

				}catch(DatabaseException $ex){
					$this->setArg("error-code" , 2);
					DatabaseConnection::getInstance()->rollback();
				}


				
			}
			
		}

	}