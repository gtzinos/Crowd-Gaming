<?php
	include_once '../app/model/mappers/actions/RequestMapper.php';

	class GetPublishRequestsController extends Controller
	{
		public function init()
		{
			$this->setOutputType( OutputType::JsonView );
		}

		public function run()
		{


			$requestMapper = new RequestMapper;


			$requests = $requestMapper->getActivePublishRequestsInfo();


			$this->setOutput("requests" , $requests);

		}
	}