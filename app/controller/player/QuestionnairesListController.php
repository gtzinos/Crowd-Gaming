<?php

	class QuestionnairesListController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/QuestionnairesListPageView.php');
			$this->defSection('JAVASCRIPT','player/QuestionnairesListPageView.php');
			$this->defSection('MAIN_CONTENT','player/QuestionnairesListPageView.php');


		}

		public function run(){

		}

	}
