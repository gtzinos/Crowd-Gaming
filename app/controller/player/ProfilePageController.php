<?php
	include_once '../app/model/mappers/user/UserMapper.php';


	class ProfilePageController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/ProfilePageView.php');
			$this->defSection('JAVASCRIPT','player/ProfilePageView.php');
			$this->defSection('MAIN_CONTENT','player/ProfilePageView.php');

		}

		public function run(){

			$mapper = new UserMapper();

			$user = $mapper->findById( $_SESSION["USER_ID"] );

			if( $user ){

				$this->setArg("user" , $user);

			}else{
				// User with id SESSION["USER_ID"] does not exists
				// This error should never happen
				$this->setArg("error-code" , 1);
			}

		}

	}
