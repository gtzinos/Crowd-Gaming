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

				$requestMapper = new RequestMapper;

				$examinerRequests = array();
				$playerRequests = array();

				if( isset( $_POST["request-type"] ) && ($_POST["request-type"]=='1' || $_POST["request-type"]=='2'  ) )
				{
					if( $_POST["request-type"]=='1' )
						$examinerRequests = $requestMapper->getActiveRequestsInfo( $_POST["questionnaire-id"] , 1);
					else
						$playerRequests = $requestMapper->getActiveRequestsInfo( $_POST["questionnaire-id"] , 2 );
				}
				else
				{
					$examinerRequests = $requestMapper->getActiveRequestsInfo( $_POST["questionnaire-id"] , 1);
					$playerRequests = $requestMapper->getActiveRequestsInfo( $_POST["questionnaire-id"] , 2 );
				}

				$this->setOutput("response-code" , 0);
				$this->setOutput("requests" , array_merge($playerRequests , $examinerRequests) );
			}

		}
	}