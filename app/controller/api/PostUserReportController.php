<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/PlaythroughMapper.php';
	include_once '../app/model/mappers/user/UserReportMapper.php';

	class UserAnswerController extends AuthenticatedController
	{

		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{

			$userId = $this->authenticateToken();

			$httpBody = file_get_contents('php://input');
			$parameters = json_decode($httpBody,true);

			if( ! isset( $parameters["questionnaire-id"] , $parameters["report-comment"] ) )
			{
				$this->setOutput( "code" , "612");
				$this->setOutput( "message" , "You didn't provide questionnaire-id or report-comment");
				return;
			}

			if( strlen($parameters["report-comment"])>255 )
			{
				$this->setOutput( "code" , "613");
				$this->setOutput( "message" , "Report comment validation error");
				return;
			}

			$participationMapper = new ParticipationMapper;
			$userReportMapper = new UserReportMapper;
			$PlaythroughMapper = new PlaythroughMapper;



			if( !$participationMapper->participates($userId , $parameters["questionnaire-id"] , 1) )
			{
				$this->setOutput("code" , "604");
				$this->setOutput("message" , "Forbidden, You dont have access to that questionnaire" );
				return;
			}

			
			

		}

	}
