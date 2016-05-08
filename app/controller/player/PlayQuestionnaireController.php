<?php
	class PlayQuestionnaireController extends Controller{

		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/PlayQuestionnaireView.php');
			$this->defSection('JAVASCRIPT','player/PlayQuestionnaireView.php');
			$this->defSection('MAIN_CONTENT','player/PlayQuestionnaireView.php');

		}

		public function run(){

		}

	}
