<?php


	class GetUserReportsController extends Controller
	{

		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{

			if( isset($_POST["questionnaire-id"]) )
			{
				
			}
		}

	}