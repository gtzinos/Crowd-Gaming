<?php

	class InvalidRequestController extends Controller{
		
		public function init(){
			$this->setHeadless(true);
			
		}

		public function run(){

			$response["code"] = "400";
			$response["verbal"] = "Invalid Request";

			print json_encode($response);
		}

	}