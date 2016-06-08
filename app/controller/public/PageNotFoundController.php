<?php

	class PageNotFoundController extends Controller{


		public function init(){
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','public/PageNotFoundView.php');
			$view->defSection('JAVASCRIPT','public/PageNotFoundView.php');
			$view->defSection('MAIN_CONTENT','public/PageNotFoundView.php');

			$view->setArg("PAGE_TITLE","This page does not exist");

			$this->setView( $view);
		}

		public function run(){
			
		}

	}