<?php
	include_once '../app/model/mappers/actions/RequestMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class GetQuestionnaireRequests extends Controller
	{
		public function init()
		{
			$this->setOutputType( OutputType::JsonView );
		}

		public function run()
		{
			$requestMapper = new RequestMapper;

			$limit = 10;
			$offset = 0;

			if( isset( $_POST["limit"]) && $_POST["limit"]>0  )
				$limit = $_POST["limit"];

			if( isset( $_POST["offset"]) && $_POST["offset"]>0 )
				$offset = $_POST["offset"];


			/*
				Reponse Codes
				0 : All ok
				1 : Invalid Access
			 */
			if( isset( $_POST["questionnaire-id"] ) )
			{

				$participationMapper = new ParticipationMapper;

				if( !( $participationMapper->participates($_SESSION["USER_ID"] , $_POST["questionnaire-id"] , 2 ) || $_SESSION["USER_LEVEL"]=3 ) )
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				$examinerRequests = array();
				$playerRequests = array();

				if( isset( $_POST["request-type"] ) && ($_POST["request-type"]=='1' || $_POST["request-type"]=='2'  ) )
				{
					if( $_POST["request-type"]=='1' )
						$examinerRequests = $requestMapper->getAllActiveRequestsInfo( $_POST["questionnaire-id"] , 1 , $offset , $limit);
					else
						$playerRequests = $requestMapper->getAllActiveRequestsInfo( $_POST["questionnaire-id"] , 2 , $offset , $limit );
				}
				else
				{
					$examinerRequests = $requestMapper->getAllActiveRequestsInfo( $_POST["questionnaire-id"] , null , $offset , $limit);
				}

				$this->setOutput("response-code" , 0);
				$this->setOutput("requests" , array_merge($playerRequests , $examinerRequests) );
			}
			else
			{
				$examinerRequests = array();
				$playerRequests = array();

				if( isset( $_POST["request-type"] ) && ($_POST["request-type"]=='1' || $_POST["request-type"]=='2'  ) )
				{
					if( $_POST["request-type"]=='1' )
						$examinerRequests = $requestMapper->getAllActiveRequestsInfo(null ,1 , $offset , $limit);
					else
						$playerRequests = $requestMapper->getAllActiveRequestsInfo(null , 2 , $offset , $limit);
				}
				else
				{
					$examinerRequests = $requestMapper->getAllActiveRequestsInfo(null ,null , $offset , $limit);
				}

				$this->setOutput("response-code" , 0);
				$this->setOutput("requests" , array_merge($playerRequests , $examinerRequests) );
			}

		}
	}