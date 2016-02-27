<?php

	class ProfilePageController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','public/ProfilePageView.php');
			$this->defSection('JAVASCRIPT','public/ProfilePageView.php');
			$this->defSection('MAIN_CONTENT','public/ProfilePageView.php');

		}

		public function run(){

		}

	}
