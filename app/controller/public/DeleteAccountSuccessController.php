<?php

	class DeleteAccountSuccessController extends Controller{

		public function init(){
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);
			$view->defSection('MAIN_CONTENT','public/DeleteAccountSuccessView.php');

			$view->setArg("PAGE_TITLE","Your Account has been deleted");

			$this->setView( $view);
		}

		public function run(){


			if( isset( $_SESSION["SIGN_UP_CACHE_EMAIL"] , $_SESSION["SIGN_UP_CACHE_NAME"] , $_SESSION["SIGN_UP_CACHE_SURNAME"]) ){
				$this->setArg("email" , $_SESSION["SIGN_UP_CACHE_EMAIL"]);
				$this->setArg("name" , $_SESSION["SIGN_UP_CACHE_NAME"]);
				$this->setArg("surname" , $_SESSION["SIGN_UP_CACHE_SURNAME"]);
			}else{
				$this->redirect("");
			}
		}

	}
