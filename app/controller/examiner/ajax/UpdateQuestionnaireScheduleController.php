<?php
	
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireScheduleMapper.php';

	class UpdateQuestionnaireScheduleController extends Controller
	{
		public function init()
		{
			$this->setOutputType(OutputType::ResponseStatus );
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

				/*
					input json example

					{
						"start-date" : "12/13/1994",
						"end-date" : "12/12/1232",
						"days" : {
							"1" : { "start-time":"20:30","end-time":"21:40" },
							"4" : { "start-time":"20:30","end-time":"21:40" }
						}
					}
				 */

				$dataInput = json_decode($_POST["data"] ,true);
				$newSchdules = array();

				if( isset( $dataInput['days'] ) )
				{
					foreach ($dataInput['days'] as $day => $times) 
					{
						$startTime = explode(":", $times["start-time"]);
						$endTime = explode(":" , $times["end-time"]);

						if( $day<1 || $day>7  ||
							count($startTime)!=2 || $startTime[0]<0 || $startTime[0]>24 || $startTime[1]<0 || $startTime[1]>60 ||
							count($endTime)!=2 || $endTime[0]<0 || $endTime[0]>24 || $endTime[1]<0 || $endTime[1]>60)
						{
							$this->setOutput("response-code" , 2);
							return;
						}


						$schedule = new QuestionnaireSchedule;

						$schedule->setQuestionnaireId($_POST["questionnaire-id"]);
						$schedule->setStartDate( $dataInput['start-date'] );
						$schedule->setEndDate( $dataInput['end-date'] );
						$schedule->setDay( $day);
						$schedule->setStartTime( ((int)$startTime[0]) * 60 + ( (int) $startTime[1]) );

					

						$schedule->setEndTime( ((int)$endTime[0]) * 60 + ( (int) $endTime[1]) );

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