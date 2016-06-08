<?php
	include_once '../app/model/mappers/actions/RequestMapper.php';

	class GetPublishRequestsController extends Controller
	{
		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{
			$offset = 0;
			$limit = 10;

			if( isset($_POST["offset"]) && $_POST["offset"] > 0 )
				$offset = $_POST["offset"];

			if( isset($_POST["limit"]) && $_POST["limit"] >= 0 )
				$limit = $_POST["limit"];

			$requestMapper = new RequestMapper;

			$requests = $requestMapper->getActivePublishRequestsInfo( $offset , $limit);

			$this->setOutput("requests" , $requests);
		}
	}