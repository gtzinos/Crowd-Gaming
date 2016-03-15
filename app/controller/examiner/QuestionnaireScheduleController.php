<?php

	class QuestionnaireScheduleController extends Controller{
		
		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','examiner/QuestionnaireScheduleView.php');
			$this->defSection('JAVASCRIPT','examiner/QuestionnaireScheduleView.php');
			$this->defSection('MAIN_CONTENT','examiner/QuestionnaireScheduleView.php');
			
		}

		public function run(){

		}

	}