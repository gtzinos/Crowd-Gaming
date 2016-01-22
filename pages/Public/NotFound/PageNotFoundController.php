<?php
	class PageNotFoundController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS',dirname(__FILE__).'/PageNotFoundView.php');
			$this->defSection('JAVASCRIPT',dirname(__FILE__).'/PageNotFoundView.php');
			$this->defSection('MAIN_CONTENT',dirname(__FILE__).'/PageNotFoundView.php');

		}

		public function run(){

		}

	}