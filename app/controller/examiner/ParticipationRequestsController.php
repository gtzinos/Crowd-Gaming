<?php

	class ParticipationRequestsController extends Controller
	{

		public function init()
		{
			if( isset($this->params[1]) && $this->params[1]=="ajax")
			{
				$this->setHeadless(true);
			}
			else
			{
				global $_CONFIG;

				$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

				$this->defSection('CSS','moderator/ParticipationRequestsView.php');
				$this->defSection('JAVASCRIPT','moderator/ParticipationRequestsView.php');
				$this->defSection('MAIN_CONTENT','moderator/ParticipationRequestsView.php');
			}

			$this->setArg("PAGE_TITLE","Participation Requests");
		}

		public function run()
		{


		}

	}
