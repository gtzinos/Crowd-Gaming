<?php
	
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireScheduleMapper.php';

	class UpdateQuestionnaireScheduleController extends Controller
	{
		public function init()
		{
			$this->setView( new CodeView );
		}

		public function run()
		{

			/*
				0 : all ok
				1 : Invalid Access
				2 : Data Validation error
				3 : Database Error
				-1: No data
			 */
			if( isset($_POST["questionnaire-id"] , $_POST["data"]) )
			{

				$participationMapper = new ParticipationMapper;

				if( !( $participationMapper->participates($_SESSION["USER_ID"] , $_POST["questionnaire-id"] , 2) || $_SESSION["USER_LEVEl"]==3 ) )
				{
					$this->setOutput("response-code" , 1);
					return;
				}


				$dataInput = json_decode($_POST["data"] ,true);
				$newSchdules = array();

				if( ($dataInput['start-date'] !== null && $dataInput['start-date'] === null) || 
					($dataInput['start-date'] === null && $dataInput['start-date'] !== null) )
				{
					$this->setOutput("response-code" , 5);
					return;
				}

				if( count( $dataInput['days'] ) >0 )
				{

					foreach ($dataInput['days'] as $day => $times) 
					{

						if(  intval($day) <1 || intval($day) >7 ||
							 $times["start-time"] < 0 || $times["start-time"] > 1440 ||
							 $times["end-time"] < 0 || $times["end-time"] > 1440 ||
							 $times["start-time"] > $times["end-time"] )
						{
							$this->setOutput("response-code" , 2);
							return;
						}


						$schedule = new QuestionnaireSchedule;

						$schedule->setQuestionnaireId($_POST["questionnaire-id"]);
						$schedule->setStartDate( $dataInput['start-date'] );
						$schedule->setEndDate( $dataInput['end-date'] );
						$schedule->setDay( $day);
						$schedule->setStartTime( $times["start-time"] );
						$schedule->setEndTime( $times["end-time"] );

						$newSchdules[] = $schedule;
					}
				}
				else
				{
					$schedule = new QuestionnaireSchedule;

					$schedule->setQuestionnaireId($_POST["questionnaire-id"]);
					$schedule->setStartDate( $dataInput['start-date']);
					$schedule->setEndDate( $dataInput['end-date'] );
					$schedule->setDay(0);
					$schedule->setStartTime(0);
					$schedule->setEndTime(1440);

					$newSchdules[] = $schedule;
				}

				$scheduleMapper = new QuestionnaireScheduleMapper;
				$oldSchedules = $scheduleMapper->findByQuestionnaire($_POST["questionnaire-id"]);

				try
				{
					DatabaseConnection::getInstance()->startTransaction();
					
					foreach ($oldSchedules as $schedule) 
					{
						$scheduleMapper->delete($schedule);
					}

					foreach ($newSchdules as $schedule) 
					{
						$scheduleMapper->persist($schedule);
					}

					DatabaseConnection::getInstance()->commit();
					$this->setOutput("response-code" , 0);
				}
				catch( DatabaseException $e)
				{
					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("response-code" , 3);
				}


				$this->setOutput("response-code" , 0);
				return;
			}

			$this->setOutput("response-code" , -1);
		}
	}