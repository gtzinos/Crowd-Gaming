<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/PlaythroughMapper.php';
	include_once '../app/model/mappers/user/UserReportMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';

	class PostUserReportController extends AuthenticatedController
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
			$playthroughMapper = new PlaythroughMapper;
			$questionnaireMapper = new QuestionnaireMapper;



			if( !$participationMapper->participates($userId , $parameters["questionnaire-id"] , 1) )
			{
				$this->setOutput("code" , "604");
				$this->setOutput("message" , "Forbidden, You dont have access to that questionnaire" );
				return;
			}

			if( !$questionnaireMapper->isPublic($parameters["questionnaire-id"]) )
			{
				$this->setOutput("code" , "603");
				$this->setOutput("message" , "Forbidden, Questionnaire offline");
				return;
			}

			if( !$playthroughMapper->isQuestionnaireCompleted($userId , $parameters["questionnaire-id"]))
			{
				$this->setOutput("code" , "614");
				$this->setOutput("message" , "You cant complete this action because Questionnaire is not completed.");
				return;
			}

			$reportComment = htmlspecialchars($parameters["report-comment"]);
			
			try
			{
				
				$userReportMapper->insert($userId , $parameters["questionnaire-id"] , $reportComment);

				$this->setOutput("code" , "200");
				$this->setOutput("message" , "Completed!");
			}
			catch(DatabaseException $ex)
			{
				$this->setOutput("code" , "615");
				$this->setOutput("message" , "You cant post a report for this questionnaire.");
			}

		}

	}
