<?php

	class InfoPageController extends Controller{


		public function init(){
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);
			$view->defSection('MAIN_CONTENT','public/InfoPageView.php');
			$view->setArg("PAGE_TITLE","Crowd Gaming");

			$this->setView($view);
		}

		public function run(){

		}

	}
