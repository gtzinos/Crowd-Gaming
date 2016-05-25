<?php
	class QuestionnaireResultsController extends Controller{

		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/QuestionnaireResultsView.php');
			$this->defSection('JAVASCRIPT','player/QuestionnaireResultsView.php');
			$this->defSection('MAIN_CONTENT','player/QuestionnaireResultsView.php');
		}

		public function run(){

		}

	}
