<?php
	
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireScheduleMapper.php';

	class GetQuestionnaireScheduleController extends Controller
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

				if( !( $participationMapper->participates($_SESSION["USER_ID"] , $_POST["questionnaire-id"] , 2) || $_SESSION["USER_LEVEL"]==3 ) )
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				$scheduleMapper = new QuestionnaireScheduleMapper;
				$schedules = $scheduleMapper->findByQuestionnaire($_POST["questionnaire-id"]);

				$schedulesToPersist = array();
				$out = array();

				foreach ($schedules as $schedule) 
				{
					$arrayItem["id"] = $schedule->getId();
					$arrayItem["day"] = $schedule->getDay();
					$arrayItem["questionnaire-id"] = $schedule->getQuestionnaireId();
					$arrayItem["start-time"] = $schedule->getStartTime();
					$arrayItem["start-date"] = $schedule->getStartDate();
					$arrayItem["end-time"] = $schedule->getEndTime();
					$arrayItem["end-date"] = $schedule->getEndDate();

					$out[] = $arrayItem;
				}

				$this->setOutput("response-code" , 0);
				$this->setOutput("schedule" , $out);
			}
		}
	}