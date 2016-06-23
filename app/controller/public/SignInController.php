<?php
	include_once '../app/model/domain/user/User.php';
	include_once '../app/model/mappers/user/UserMapper.php';

	class SignInController extends Controller{

		public function init(){
			$this->setHeadless(true);
		}

		public function run(){
			if( isset($_SESSION["USER_ID"]) || ( !isset($_POST["email"] , $_POST["password"] , $_POST["recaptcha"]) ) ){
				$this->redirect("home");
			}

			global $_CONFIG;

			/*
				Captcha Check
			*/ 
			$curl = curl_init();

			curl_setopt( $curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
			curl_setopt( $curl, CURLOPT_POST ,1);
			curl_setopt( $curl, CURLOPT_POSTFIELDS , 'response='.$_POST['recaptcha'].'&secret='.$_CONFIG["SERVER_GOOGLE_RECAPTCHA_KEY"]);			
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);

			$responseJson = curl_exec($curl);

			$response = json_decode($responseJson , true);

			if( $response["success"] != true )
			{
				print 2;
				return;
			}
			

			header('Content-Type: text/plain');

			$userMapper = new UserMapper();

			$user = $userMapper->authenticate($_POST["email"] , $_POST["password"] );
			
			if( $user ){

				if( is_object($user)){
					$user->login();
					print '0';
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