<?php

	class PublicationRequestsController extends Controller
	{

		public function init()
		{

			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','moderator/PublicationRequestsView.php');
			$view->defSection('JAVASCRIPT','moderator/PublicationRequestsView.php');
			$view->defSection('MAIN_CONTENT','moderator/PublicationRequestsView.php');
			

			$view->setArg("PAGE_TITLE","Publication Requests");

			$this->setView($view);
		}

		public function run()
		{


		}

	}
