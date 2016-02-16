<?php

	class HomePageController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','public/HomePageView.php');
			$this->defSection('JAVASCRIPT','public/HomePageView.php');
			$this->defSection('MAIN_CONTENT','public/HomePageView.php');
			
		}

		public function run(){

		}

	}