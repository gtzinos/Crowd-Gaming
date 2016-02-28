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

			header('Content-Type: text/plain');

			$userMapper = new UserMapper();

			$user = $userMapper->authenticate($_POST["email"] , $_POST["password"] );
			
			if( $user ){

				if( is_object($user)){
					$user->login();
					print 'TRUE';
				}else{
					// If $user is not an object i contains the error code
					// 2: Not verified 3: deleted 4: banned
					print $user;
				}

				
			}else{
				print '1'; // wrong email or password
			}
		}

	}