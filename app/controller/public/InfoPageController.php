<?php

	class InfoPageController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			//$this->defSection('CSS',dirname(__FILE__).'/InfoPageView.php');
			//$this->defSection('JAVASCRIPT',dirname(__FILE__).'/InfoPageView.php');
			$this->defSection('MAIN_CONTENT','public/InfoPageView.php');

		}

		public function run(){

		}

	}
