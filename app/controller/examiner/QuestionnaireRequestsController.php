<?php

	class QuestionnaireRequestsController extends Controller{
		
		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','examiner/QuestionnaireRequestsView.php');
			$this->defSection('JAVASCRIPT','examiner/QuestionnaireRequestsView.php');
			$this->defSection('MAIN_CONTENT','examiner/QuestionnaireRequestsView.php');
			
		}

		public function run(){

		}

	}