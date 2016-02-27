<?php

	class ProfilePageController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/ProfilePageView.php');
			$this->defSection('JAVASCRIPT','player/ProfilePageView.php');
			$this->defSection('MAIN_CONTENT','player/ProfilePageView.php');

		}

		public function run(){

		}

	}
