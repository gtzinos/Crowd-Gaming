<?php

	class InfoPageController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			//$this->defSection('CSS','public/InfoPageView.php');
			//$this->defSection('JAVASCRIPT','public/InfoPageView.php');
			$this->defSection('MAIN_CONTENT','public/InfoPageView.php');

			$this->setArg("PAGE_TITLE","Crowd Gaming");
		}

		public function run(){

		}

	}
