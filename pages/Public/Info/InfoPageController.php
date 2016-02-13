<?php
	/*
		This scripts should run only if it is included by the application.
	 */
	global $_IN_SAME_APP ;
	if(!isset($_IN_SAME_APP)){die("Not authorized access");}

	class InfoPageController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			//$this->defSection('CSS',dirname(__FILE__).'/InfoPageView.php');
			//$this->defSection('JAVASCRIPT',dirname(__FILE__).'/InfoPageView.php');
			$this->defSection('MAIN_CONTENT',dirname(__FILE__).'/InfoPageView.php');

		}

		public function run(){

		}

	}
