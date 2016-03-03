<?php
	include_once '../app/model/mappers/user/UserMapper.php';
	include_once '../app/model/mappers/user/ActivationMapper.php';

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

			//print $token;
			$activationMapper = new ActivationMapper();

			$userId = $activationMapper->findByParameter($token);

			if( !$userId ){

				$this->setArg("error-code" , 1);

			}else{

				$userMapper = new UserMapper();
				$user = $userMapper->findById($userId);

				$user->setVerified(true);

				try{
					DatabaseConnection::getInstance()->startTransaction();

					$userMapper->persist($user);
					$activationMapper->delete($userId);

					$this->setArg("error-code" , 0);

					DatabaseConnection::getInstance()->commit();

				}catch(DatabaseException $ex){
					$this->setArg("error-code" , 2);
					DatabaseConnection::getInstance()->rollback();
				}



			}

		}

	}
