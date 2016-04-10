<?php

	class CreateQuestionnaireGroupsController extends Controller{

		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);
			$this->defSection('JAVASCRIPT','examiner/CreateQuestionnaireGroupsView.php');
			$this->defSection('MAIN_CONTENT','examiner/CreateQuestionnaireGroupsView.php');

		}

		public function run(){

		}

	}
