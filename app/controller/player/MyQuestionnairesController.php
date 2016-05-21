<?php
	class MyQuestionnairesController extends Controller{

		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/MyQuestionnairesView.php');
			$this->defSection('JAVASCRIPT','player/MyQuestionnairesView.php');
			$this->defSection('MAIN_CONTENT','player/MyQuestionnairesView.php');
		}

		public function run(){

		}

	}
