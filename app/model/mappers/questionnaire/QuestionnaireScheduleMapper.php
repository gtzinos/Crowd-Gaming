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
			$query = "SELECT * FROM `QuestionnaireSchedule` WHERE `questionnaire_id`=? ORDER BY day ASC";

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

		public function findMinutesToEnd($questionnaireId)
		{
			if( $this->findMinutesToStart($questionnaireId) != 0 )
				return -1;

			$schedules = $this->findByQuestionnaire($questionnaireId);


			$maxMinutes = -1;


			$dateNowString = date("Y-m-d");
			$dateNow = new DateTime($dateNowString);

			$day = $dateNow->format('w');
			if( $day == 0)
				$day = 7;

			$now = time();
			/*
			
				3
				4
				5 -> here
				6 

			 */
			$queue = new SplQueue();
			for($i=0; $i < count($schedules); $i++)
			{
				if( $schedules[$i]->getDay() != 0 &&
					$schedules[$i]->getDay() < $day )
				{
					$queue->push( $schedules[$i] );
					unset($schedules[$i]);
				}
			}

			while( !$queue->isEmpty() )
			{
				$schedules[] = $queue->pop();
			}

			$ranges = array();



			foreach ($schedules as $schedule) 
			{
				if( $schedule->getDay() ==0 && 
					$schedule->getStartTime()==0 &&
					$schedule->getEndTime()==1440 &&
					$schedule->getStartDate()!==null &&
					$schedule->getEndDate()!==null)
				{
					$startDate = new DateTime($schedule->getStartDate());
					$endDate = new DateTime($schedule->getEndDate());

					$startTime = $startDate->getTimestamp() + ($schedule->getStartTime() * 60);
					$endTime = $endDate->getTimestamp() + ($schedule->getEndTime() *60);

					return ($endTime - $now)/60;
				}
				else if( $schedule->getDay() ==0 )
				{
					$thatDay = clone $dateNow;
					for ($i=1; $i <= 7 ; $i++) 
					{ 
						$startTime = $thatDay->getTimestamp() + ($schedule->getStartTime() * 60);
						$endTime = $thatDay->getTimestamp() + ($schedule->getEndTime() *60);

						$range["start_time"] = $startTime;
						$range["end_time"] = $endTime;

						$ranges[$schedule->getDay()][] = $range;
						
						$thatDay->modify("+1 day");
					}
				}
				else
				{
					$daysDiff =0;

					if( $day<=$schedule->getDay() )
						$daysDiff = $schedule->getDay()-$day;
					else
						$daysDiff = 7 - $day + $schedule->getDay();

					
					$thatDate = clone $dateNow;
					$thatDate->modify("+".$daysDiff." days");

				//	print "daysDiff : ".$daysDiff." Day:".$schedule->getDay()." Now:".$day." ".$thatDate->format('Y-m-d h:m');
				//	print " TimeStamp ".$thatDate->getTimestamp()." ".$schedule->getStartTime()." ".$schedule->getEndTime()."<br>";


					$startTime = $thatDate->getTimestamp() + ($schedule->getStartTime() *60);
					$endTime = $thatDate->getTimestamp() + ($schedule->getEndTime() *60);

					$range["start_time"] = $startTime;
					$range["end_time"] = $endTime;

					$ranges[$schedule->getDay()][] = $range;
				}
			}

			//Convert ranges to 1d array
			$time_windows = array();
			foreach ($ranges as $day_range) 
			{
				foreach ($day_range as $time_range) 
				{
					//print_r($time_range);
					//print '<br>';
					$time_windows[] = $time_range;
				}
			}
			//print "<br><br>";

			$count =count($time_windows);
			for ($i=1; $i < $count; $i++) 
			{ 
				if( $time_windows[$i]["start_time"] == $time_windows[$i-1]["end_time"] )
				{
					$time_windows[$i]["start_time"] = $time_windows[$i - 1]["start_time"];
					
					unset($time_windows[$i-1]);
				}
			}


			//foreach ($time_windows as $window) 
			//{
				//print_r($window);
				//print '<br>';
			//}


			foreach ($time_windows as $window) 
			{
				if( $now >= $window["start_time"] && $now <=$window["end_time"])
				{
					$maxMinutes = $window["end_time"] - $now;
					break;
				}
			}


			return (int)($maxMinutes/60);
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

			// If anyone is going to read the code bellow .. i'm sorry
			foreach ($schedules as $schedule) 
			{
				$startDate = new DateTime($schedule->getStartDate());
				$endDate = new DateTime($schedule->getEndDate());
				$startTime = $startDate->getTimestamp() + $schedule->getStartTime()*60;			
				$endTime = $endDate->getTimestamp() + $schedule->getEndTime()*60;


				if( $schedule->getStartDate() !== null && $schedule->getEndDate() !== null )
				{
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
				else
				{
					if( $schedule->getDay()==0 || $day==$schedule->getDay() )
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

						$nextDateStart = $nextDate->getTimestamp() + $schedule->getStartTime()*60;
						$min = ( $nextDateStart - $now ) / 60;
						if( $min < $minMinutes)
							$minMinutes = $min;
					}
				}				
			}

			
			if( $minMinutes == PHP_INT_MAX)
				return -1;
			return ceil($minMinutes);
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

		public function deleteByQuestionnaire($questionnaireId)
		{
			$query = "DELETE FROM `QuestionnaireSchedule` WHERE `questionnaire_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i',$questionnaireId);

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
			$query = "INSERT INTO `QuestionnaireSchedule`(`questionnaire_id`, `day`, `start_time`, `start_date`, `end_time`, `end_date`) VALUES (?,?,?,?,?,?)";

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
			$query = "UPDATE `QuestionnaireSchedule` SET `questionnaire_id`=?,`day`=?,`start_time`=?,`start_date`=?,`end_time`=?,`end_date`=?WHERE `id`=?";

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