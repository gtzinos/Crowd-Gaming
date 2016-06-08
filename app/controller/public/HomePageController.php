<?php

	class HomePageController extends Controller{


		public function init(){
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','public/HomePageView.php');
			$view->defSection('JAVASCRIPT','public/HomePageView.php');
			$view->defSection('MAIN_CONTENT','public/HomePageView.php');
			
			$view->setArg("PAGE_TITLE","Crowd Gaming");

			$this->setView($view);
		}

		public function run(){

		}

	}