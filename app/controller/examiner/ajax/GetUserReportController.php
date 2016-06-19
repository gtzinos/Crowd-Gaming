<?php
		
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/user/UserReportMapper.php';

	class GetUserReportController extends Controller
	{
		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{

			if( isset($_POST["questionnaire-id"]) )
			{
				$participationMapper = new ParticipationMapper;
				$userReportMapper = new UserReportMapper;

				if( !$participationMapper->participates($_SESSION["USER_ID"] , $_POST["questionnaire-id"] , 2) && $_SESSION["USER_LEVEL"]!=3 )
				{
					$this->setOutput("response-code" , "2" );
					$this->setOutput("message" , "You dont have access to this questionnaire");
				}
				else
				{
					$reports = $userReportMapper->findReportByQuestionnaire($_POST["questionnaire-id"]);

					$this->setOutput("response-code" , "0");
					$this->setOutput("reports" , $reports); 
				}

			}
			else
			{
				$this->setOutput("response-code" , "-1");
				$this->setOutput("message" , "You didn't privide Questionnaire id");
			}

		}
	}