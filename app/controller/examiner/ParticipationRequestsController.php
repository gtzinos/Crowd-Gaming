<?php

	class ParticipationRequestsController extends Controller
	{

		public function init()
		{

			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','moderator/ParticipationRequestsView.php');
			$view->defSection('JAVASCRIPT','moderator/ParticipationRequestsView.php');
			$view->defSection('MAIN_CONTENT','moderator/ParticipationRequestsView.php');

			$view->setArg("PAGE_TITLE","Participation Requests");
					
			$this->setView($view);	
		}

		public function run()
		{


		}

	}
