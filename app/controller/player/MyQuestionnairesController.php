<?php
	class MyQuestionnairesController extends Controller
	{

		public function init()
		{
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','player/MyQuestionnairesView.php');
			$view->defSection('JAVASCRIPT','player/MyQuestionnairesView.php');
			$view->defSection('MAIN_CONTENT','player/MyQuestionnairesView.php');

			$this->setView($view);
		}

		public function run()
		{

		}

	}
