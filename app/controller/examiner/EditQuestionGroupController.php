<?php

	class EditQuestionGroupController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('JAVASCRIPT','examiner/EditQuestionGroupView.php');
			$this->defSection('MAIN_CONTENT','examiner/EditQuestionGroupView.php');

		}

		public function run(){

		}

	}
