<?php
	include_once '../app/model/domain/user/User.php';
	include_once '../app/model/mappers/user/UserMapper.php';

	class SignInController extends Controller{

		public function init(){
			$this->setHeadless(true);
		}

		public function run(){

			if( isset($_SESSION["USER_ID"]) || ( !isset($_POST["email"]) && !isset($_POST["password"]) ) ){
				$this->redirect("home");
			}	


			$userMapper = new UserMapper();

			$user = $userMapper->authenticate($_POST["email"] , $_POST["password"] );

			if( $user ){
				$user->login();
				print 'TRUE';
			}else{
				print 'FALSE';
			}
		}

	}