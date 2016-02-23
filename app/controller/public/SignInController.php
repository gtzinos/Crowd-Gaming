<?php
	include_once '../app/model/user/User.php';

	class SignInController extends Controller{


		public function init(){
			$this->setHeadless(true);
		}

		public function run(){

			if( isset($_SESSION["USER_ID"]) || ( !isset($_POST["email"]) && !isset($_POST["password"]) ) ){
				$this->redirect("home");
			}

			if( User::signin($_POST["email"] , $_POST["password"] ) ){
				print 'TRUE';
			}else{
				print 'FALSE';
			}

		}

	}
