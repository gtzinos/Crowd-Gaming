<?php

	class QuestionnaireWorkbenchController extends Controller{
		
		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','examiner/QuestionnaireWorkbenchView.php');
			$this->defSection('JAVASCRIPT','examiner/QuestionnaireWorkbenchView.php');
			$this->defSection('MAIN_CONTENT','examiner/QuestionnaireWorkbenchView.php');
			
		}

		public function run(){
			
		}

	}