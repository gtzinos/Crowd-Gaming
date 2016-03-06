<?php

	class QuestionnaireController extends Controller{
		
		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/QuestionnaireView.php');
			$this->defSection('JAVASCRIPT','player/QuestionnaireView.php');
			$this->defSection('MAIN_CONTENT','player/QuestionnaireView.php');
			
		}

		public function run(){

		}

	}