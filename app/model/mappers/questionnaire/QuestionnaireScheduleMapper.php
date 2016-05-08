<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/QuestionnaireSchedule.php';

	class QuestionnaireScheduleMapper extends DataMapper{

		
		public function findAll(){
			$query = "SELECT * FROM `QuestionnaireSchedule`";

			$statement = $this->getStatement($query);

			$set = $statement->execute();

			$schedules = array();
			while($set->next()){
				$schedule = new QuestionnaireSchedule;

				$schedule->setId( $set->get("id") );
				$schedule->setDay( $set->get("day") );
				$schedule->setQuestionnaireId( $set->get("questionnaire_id") );
				$schedule->setStartTime( $set->get("start_time") );
				$schedule->setStartDate( $set->get("start_date") );
				$schedule->setEndTime( $set->get("end_time") );
				$schedule->setEndDate( $set->get("end_date") );

				$schedules[] = $schedule;
			}
			return $schedules;
		}

		public function findByQuestionnaire($questionnaireId){
			$query = "SELECT * FROM `QuestionnaireSchedule` WHERE `questionnaire_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionnaireId);

			$set = $statement->execute();

			$schedules = array();
			while($set->next()){
				$schedule = new QuestionnaireSchedule;

				$schedule->setId( $set->get("id") );
				$schedule->setDay( $set->get("day") );
				$schedule->setQuestionnaireId( $set->get("questionnaire_id") );
				$schedule->setStartTime( $set->get("start_time") );
				$schedule->setStartDate( $set->get("start_date") );
				$schedule->setEndTime( $set->get("end_time") );
				$schedule->setEndDate( $set->get("end_date") );

				$schedules[] = $schedule;
			}
			return $schedules;
		}

		public function findMinutesToStart($questionnaireId)
		{
			$schedules = $this->findByQuestionnaire($questionnaireId);

			$minMinutes = PHP_INT_MAX;

			$dateNowString = date("Y-m-d");
			$dateNow = new DateTime($dateNowString);
			$now = time();

			$day = $dateNow->format('w');
			if( $day == 0)
				$day = 7;

			foreach ($schedules as $schedule) 
			{
				$startDate = new DateTime($schedule->getStartDate());
				$endDate = new DateTime($schedule->getEndDate());
				$startTime = $startDate->getTimestamp() + $schedule->getStartTime()*60;			
				$endTime = $endDate->getTimestamp() + $schedule->getEndTime()*60;

				// After End date. its over.
				if( $dateNow>$endDate )
				{
					continue;
				}
				// Before start date
				else if( $dateNow<$startDate && $schedule->getDay()==0 )
				{
					$min = ( $startTime - $now ) / 60;
					if( $min < $minMinutes)
						$minMinutes = $min;
				}
				// Before start date, we have day restriction
				else if( $dateNow<$startDate && $schedule->getDay()!=0 )
				{
					$thatDay = $startDate->format('w');
					if( $thatDay == 0)
						$thatDay = 7;

					$daysDiff =0;
					if( $thatDay<$schedule->getDay() )
						$daysDiff = $schedule->getDay()-$thatDay;
					else
						$daysDiff = 7 - $thatDay + $schedule->getDay();

					$startNextDate = clone $startDate;
					$startNextDate->modify('+'.$daysDiff.' days');

					// its over already lol
					if( $startNextDate > $endDate)
						continue;

					$startNextDateStart = $startNextDate->getTimestamp() + $schedule->getStartTime()*60;
					$min = ( $startNextDateStart - $now ) / 60;
					if( $min < $minMinutes)
						$minMinutes = $min;

				}
				// Questionnarie starts somewhere today
				else if( $schedule->getDay()==0 || $day==$schedule->getDay() )
				{
					$todayStart = $dateNow->getTimestamp() + $schedule->getStartTime()*60;
					$todayEnd = $dateNow->getTimestamp() + $schedule->getEndTime()*60;

					// check next time this record repeats
					if( $now > $todayEnd )
					{
						$nextWeek = clone $dateNow;

						if( $schedule->getDay()==0 )
							$nextWeek->modify('+1 day');
						else
							$nextWeek->modify('+1 week');
						
						// its over
						if( $nextWeek > $endDate)
							continue;

						$nextWeekStart = $nextWeek->getTimestamp() + $schedule->getStartTime()*60;
						$min = ( $nextWeekStart - $now ) / 60;
						if( $min < $minMinutes)
							$minMinutes = $min;
					}
					// today before start time
					else if( $now < $todayStart)
					{
						$min = ( $todayStart - $now ) / 60;
						if( $min < $minMinutes)
							$minMinutes = $min;
					}
					else
						$minMinutes = 0;
				}
				else
				{
					$daysDiff =0;
					if( $day<$schedule->getDay() )
						$daysDiff = $schedule->getDay()-$day;
					else
						$daysDiff = 7 - $day + $schedule->getDay();

					$nextDate = clone $dateNow;
					$nextDate->modify('+'.$daysDiff.' days');

					// its over
					if( $nextDate > $endDate)
						continue;

					$nextDateStart = $nextDate->getTimestamp() + $schedule->getStartTime()*60;
					$min = ( $nextDateStart - $now ) / 60;
					if( $min < $minMinutes)
						$minMinutes = $min;
				}
			}

			
			if( $minMinutes == PHP_INT_MAX)
				return -1;
			return (int)$minMinutes;
		}

		public function findById($scheduleId){
			$query = "SELECT * FROM `QuestionnaireSchedule` WHERE `id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $scheduleId);

			$set = $statement->execute();

			if($set->next()){
				$schedule = new QuestionnaireSchedule;

				$schedule->setId( $set->get("id") );
				$schedule->setDay( $set->get("day") );
				$schedule->setQuestionnaireId( $set->get("questionnaire_id") );
				$schedule->setStartTime( $set->get("start_time") );
				$schedule->setStartDate( $set->get("start_date") );
				$schedule->setEndTime( $set->get("end_time") );
				$schedule->setEndDate( $set->get("end_date") );

				return $schedule;
			}
			return null;
		}

		public function delete($questionnaireSchedule){
			$query = "DELETE FROM `QuestionnaireSchedule` WHERE `id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionnaireSchedule->getId() );

			$statement->executeUpdate();
		}

		public function persist($questionnaireSchedule){
			if( $questionnaireSchedule->getId() === null ){
				$this->_create($questionnaireSchedule);
			}else{
				$this->_update($questionnaireSchedule);
			}
		}

		private function _create($questionnaireSchedule){
			$query = "INSERT INTO `QuestionnaireSchedule`(`questionnaire_id`, `day`, `start_time`, `start_date`, `end_time`, `end_date`) VALUES (?,?,?,STR_TO_DATE(?, '%d/%m/%Y'),?,STR_TO_DATE(?, '%d/%m/%Y'))";

			$statement = $this->getStatement($query);
			$statement->setParameters('iiisis' ,
				$questionnaireSchedule->getQuestionnaireId(),
				$questionnaireSchedule->getDay(),
				$questionnaireSchedule->getStartTime(),
				$questionnaireSchedule->getStartDate(),
				$questionnaireSchedule->getEndTime(),
				$questionnaireSchedule->getEndDate() );

			$statement->executeUpdate();
		}

		private function _update($questionnaireSchedule){
			$query = "UPDATE `QuestionnaireSchedule` SET `questionnaire_id`=?,`day`=?,`start_time`=?,`start_date`=STR_TO_DATE(?, '%d/%m/%Y'),`end_time`=?,`end_date`=STR_TO_DATE(?, '%d/%m/%Y') WHERE `id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('iiisisi' ,
				$questionnaireSchedule->getQuestionnaireId(),
				$questionnaireSchedule->getDay(),
				$questionnaireSchedule->getStartTime(),
				$questionnaireSchedule->getStartDate(),
				$questionnaireSchedule->getEndTime(),
				$questionnaireSchedule->getEndDate(),
				$questionnaireSchedule->getId() );

			$statement->executeUpdate();
		}

	}