<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/actions/Participation.php';

	class ParticipationMapper extends DataMapper{

		public function findParticipation($playerId , $questionnaireId , $type){
			$query = "SELECT * FROM `QuestionnaireParticipation` WHERE `user_id`=? AND `questionnaire_id`=? AND `participation_type`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('iii',$playerId,$questionnaireId,$type);

			$set = $statement->execute();

			if($set->next()){
				$participation = new Participation;
				$participation->setUserId( $set->get("user_id") );
				$participation->setQuestionnaireId( $set->get("questionnaire_id") );
				$participation->setParticipationType( $set->get("participation_type") );
				$participation->setParticipationDate( $set->get("participation_date") );

				return $participation;
			}
			return null;
		}

		public function findByQuestionnaire($questionnaireId , $participationType = null)
		{
			$statement = null;

			if( $participationType === null)
			{
				$query = "SELECT * FROM `QuestionnaireParticipation` WHERE `questionnaire_id`=?";
				$statement = $this->getStatement($query);
				$statement->setParameters('i' , $questionnaireId);
			}
			else
			{
				$query = "SELECT * FROM `QuestionnaireParticipation` WHERE `questionnaire_id`=? AND `participation_type`=?";
				$statement = $this->getStatement($query);
				$statement->setParameters('ii' , $questionnaireId , $participationType);
			}

			$set = $statement->execute();

			$participations = array();

			while($set->next()){
				$participation = new Participation;
				$participation->setUserId( $set->get("user_id") );
				$participation->setQuestionnaireId( $set->get("questionnaire_id") );
				$participation->setParticipationType( $set->get("participation_type") );
				$participation->setParticipationDate( $set->get("participation_date") );

				$participations[] =  $participation;
			}

			return $participations;
		}


		public function participates($playerId , $questionnaireId , $type, $isPublic = null){
			$statement = null;

			if( $isPublic === null)
			{	
				$query = "SELECT `user_id` FROM `QuestionnaireParticipation` WHERE `user_id`=? AND `questionnaire_id`=? AND `participation_type`=?";

				$statement = $this->getStatement($query);
				$statement->setParameters('iii',$playerId,$questionnaireId,$type);	
			}
			else
			{
				$query = "SELECT `QuestionnaireParticipation`.`user_id` FROM `QuestionnaireParticipation`
						  INNER JOIN `Questionnaire` on `Questionnaire`.`id`=`QuestionnaireParticipation`.`questionnaire_id`
						  WHERE `QuestionnaireParticipation`.`user_id`=? 
						  AND `QuestionnaireParticipation`.`questionnaire_id`=? 
						  AND `QuestionnaireParticipation`.`participation_type`=?
						  AND `Questionnaire`.`public`=?";

				$statement = $this->getStatement($query);
				$statement->setParameters('iiii',$playerId,$questionnaireId,$type , $isPublic);	
			}

			$set = $statement->execute();

			if($set->getRowCount()>0){
				return true;
			}else{
				return false;
			}
		}

		public function participatesInGroup($playerId , $groupId , $type , $isPublic = null){
			$statement = null;

			if( $isPublic !== null)
			{
				$query = "SELECT `QuestionnaireParticipation`.`user_id` FROM `QuestionnaireParticipation`
					  INNER JOIN `QuestionGroup` on `QuestionGroup`.`questionnaire_id`=`QuestionnaireParticipation`.`questionnaire_id` 
					  WHERE `QuestionnaireParticipation`.`user_id`=? 
					  AND `QuestionGroup`.`id`=? 
					  AND `QuestionnaireParticipation`.`participation_type`=?";

				$statement = $this->getStatement($query);
				$statement->setParameters('iii',$playerId,$groupId,$type);
			}
			else
			{
				$query =   "SELECT `QuestionnaireParticipation`.`user_id` FROM `QuestionnaireParticipation`
					  	  	INNER JOIN `QuestionGroup` on `QuestionGroup`.`questionnaire_id`=`QuestionnaireParticipation`.`questionnaire_id`
					  	  	INNER JOIN `Questionnaire` on `Questionnaire`.`id`=`QuestionnaireParticipation`.`questionnaire_id`
					  		WHERE `QuestionnaireParticipation`.`user_id`=? 
					  		AND `QuestionGroup`.`id`=? 
					  		AND `QuestionnaireParticipation`.`participation_type`=?
					  		AND `Questionnaire`.`public`=?";

				$statement = $this->getStatement($query);
				$statement->setParameters('iiii',$playerId,$groupId,$type,$isPublic);
			}



			$set = $statement->execute();

			if($set->getRowCount()>0){
				return true;
			}else{
				return false;
			}
		}

		public function participatesInQuestion($playerId , $questionId , $type , $isPublic = null){

			$statement = null;

			if( $isPublic !== null)
			{
				$query = "SELECT `QuestionnaireParticipation`.`user_id` FROM `QuestionnaireParticipation`
					  INNER JOIN `QuestionGroup` on `QuestionGroup`.`questionnaire_id`=`QuestionnaireParticipation`.`questionnaire_id`
					  INNER JOIN `Question` on `Question`.`question_group_id`=`QuestionGroup`.`id` 
					  WHERE `QuestionnaireParticipation`.`user_id`=? 
					  AND `Question`.`id`=? 
					  AND `QuestionnaireParticipation`.`participation_type`=?";

				$statement = $this->getStatement($query);
				$statement->setParameters('iii',$playerId,$questionId,$type);
			}
			else
			{
				$query = "SELECT `QuestionnaireParticipation`.`user_id` FROM `QuestionnaireParticipation`
						  INNER JOIN `QuestionGroup` on `QuestionGroup`.`questionnaire_id`=`QuestionnaireParticipation`.`questionnaire_id`
						  INNER JOIN `Question` on `Question`.`question_group_id`=`QuestionGroup`.`id` 
						  INNER JOIN `Questionnaire` on `Questionnaire`.`id`=`QuestionGroup`.`questionnaire_id`
						  WHERE `QuestionnaireParticipation`.`user_id`=? 
						  AND `Question`.`id`=? 
					  	  AND `QuestionnaireParticipation`.`participation_type`=?
					  	  AND `Questionnaire`.`public`=?";

				$statement = $this->getStatement($query);
				$statement->setParameters('iiii',$playerId,$questionId,$type,$isPublic);
			}


			$set = $statement->execute();

			if($set->getRowCount()>0){
				return true;
			}else{
				return false;
			}
		}

		public function deleteByQuestionnaire($questionnaireId){
			$query = "DELETE FROM `QuestionnaireParticipation` WHERE `questionnaire_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i', $questionnaireId);

			$statement->executeUpdate();
		}

		public function delete($participation){
			$query = "DELETE FROM `QuestionnaireParticipation` WHERE `user_id`=? AND `questionnaire_id`=? AND `participation_type`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('iii',
				$participation->getUserId(),
				$participation->getQuestionnaireId(),
				$participation->getParticipationType() );

			$statement->executeUpdate();
		}

		public function persist($participation){
			$this->_create($participation);
		}

		private function _create($participation){
			$query = "INSERT INTO `QuestionnaireParticipation`(`user_id`, `questionnaire_id`, `participation_type`, `participation_date`) VALUES (?,?,?,CURRENT_TIMESTAMP)";

			$statement = $this->getStatement($query);
			$statement->setParameters('iii',
				$participation->getUserId(),
				$participation->getQuestionnaireId(),
				$participation->getParticipationType() );

			$statement->executeUpdate();
		}

	}