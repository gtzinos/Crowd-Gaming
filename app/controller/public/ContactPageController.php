<?php

	class ContactPageController extends Controller{

		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','public/ContactPageView.php');
			$this->defSection('JAVASCRIPT','public/ContactPageView.php');
			$this->defSection('MAIN_CONTENT','public/ContactPageView.php');

		}

		public function run(){

		}

	}
