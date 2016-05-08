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

			$dateNow = date("d-m-y");

			foreach ($schedules as $schedule) 
			{
				
			}

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