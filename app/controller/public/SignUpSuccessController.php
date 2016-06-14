<?php

	class SignUpSuccessController extends Controller{

		public function init(){
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','public/SignUpSuccessView.php');
			$view->defSection('JAVASCRIPT','public/SignUpSuccessView.php');
			$view->defSection('MAIN_CONTENT','public/SignUpSuccessView.php');

			$view->setArg("PAGE_TITLE","Account Successfuly Created!");

			$this->setView( $view );
		}

		public function run(){


			if( isset( $_SESSION["SIGN_UP_CACHE_EMAIL"] , $_SESSION["SIGN_UP_CACHE_NAME"] , $_SESSION["SIGN_UP_CACHE_SURNAME"]) ){
				$this->setOutput("email" , $_SESSION["SIGN_UP_CACHE_EMAIL"]);
				$this->setOutput("name" , $_SESSION["SIGN_UP_CACHE_NAME"]);
				$this->setOutput("surname" , $_SESSION["SIGN_UP_CACHE_SURNAME"]);
				unset($_SESSION["SIGN_UP_CACHE_EMAIL"]);
				unset($_SESSION["SIGN_UP_CACHE_NAME"]);
				unset($_SESSION["SIGN_UP_CACHE_SURNAME"]);
			}else{
				$this->redirect("");
			}
		}

	}
