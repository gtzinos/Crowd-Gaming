<?php

	class PublicationRequestsController extends Controller
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

				$this->defSection('CSS','moderator/PublicationRequestsView.php');
				$this->defSection('JAVASCRIPT','moderator/PublicationRequestsView.php');
				$this->defSection('MAIN_CONTENT','moderator/PublicationRequestsView.php');
			}

			$this->setArg("PAGE_TITLE","Publication Requests");
		}

		public function run()
		{


		}

	}
