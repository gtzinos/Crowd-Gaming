<?php

	class QuestionnaireEditController extends Controller{
		
		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','examiner/QuestionnaireEditView.php');
			$this->defSection('JAVASCRIPT','examiner/QuestionnaireEditView.php');
			$this->defSection('MAIN_CONTENT','examiner/QuestionnaireEditView.php');
			
		}

		public function run(){

		}

	}