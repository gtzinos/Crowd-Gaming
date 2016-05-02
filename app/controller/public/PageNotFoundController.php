<?php

	class PageNotFoundController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','public/PageNotFoundView.php');
			$this->defSection('JAVASCRIPT','public/PageNotFoundView.php');
			$this->defSection('MAIN_CONTENT','public/PageNotFoundView.php');

			$this->setArg("PAGE_TITLE","This page does not exist");
		}

		public function run(){
			
		}

	}