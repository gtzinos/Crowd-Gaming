<?php
	include_once 'AuthenticatedController.php';

	class InvalidRequestController extends AuthenticatedController
	{
		
		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{
			$userId = $this->authenticateToken();

			$this->setOutput("code","400");
			$this->setOutput("message","Invalid Request");			
		}

	}