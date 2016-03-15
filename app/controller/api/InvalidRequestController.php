<?php
	include_once 'AuthenticatedController.php';

	class InvalidRequestController extends AuthenticatedController{
		
		public function init(){

		}

		public function run(){
			$userId = $this->authenticateToken();

			$response["code"] = "400";
			$response["message"] = "Invalid Request";

			print json_encode($response);
		}

	}