<?php

	class SignUpSuccessController extends Controller{

		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','public/SignUpSuccessView.php');
			$this->defSection('JAVASCRIPT','public/SignUpSuccessView.php');
			$this->defSection('MAIN_CONTENT','public/SignUpSuccessView.php');

			$this->setArg("PAGE_TITLE","Account Successfuly Created!");
		}

		public function run(){


			if( isset( $_SESSION["SIGN_UP_CACHE_EMAIL"] , $_SESSION["SIGN_UP_CACHE_NAME"] , $_SESSION["SIGN_UP_CACHE_SURNAME"]) ){
				$this->setArg("email" , $_SESSION["SIGN_UP_CACHE_EMAIL"]);
				$this->setArg("name" , $_SESSION["SIGN_UP_CACHE_NAME"]);
				$this->setArg("surname" , $_SESSION["SIGN_UP_CACHE_SURNAME"]);
				unset($_SESSION["SIGN_UP_CACHE_EMAIL"]);
				unset($_SESSION["SIGN_UP_CACHE_NAME"]);
				unset($_SESSION["SIGN_UP_CACHE_SURNAME"]);
			}else{
				$this->redirect("");
			}
		}

	}
