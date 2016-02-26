<?php

	include_once '../app/model/domain/user/User.php';

	class SignOutController extends Controller{


		public function init(){
			$this->setHeadless(true);
		}

		public function run(){

			if( isset($_SESSION["USER_ID"]) ){
				$user = new User();

				$user->logout();
			}
			$this->redirect("home");

		}

	}
