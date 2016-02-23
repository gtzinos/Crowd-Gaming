<?php

	include_once '../app/model/user/User.php';

	class SignOutController extends Controller{


		public function init(){
			$this->setHeadless(true);
		}

		public function run(){


			if( isset($_SESSION["USER_ID"]) ){
				User::signout();
			}
			$this->redirect("home");

		}

	}
