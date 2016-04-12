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

		public function participates($playerId , $questionnaireId , $type){
			$query = "SELECT `user_id` FROM `QuestionnaireParticipation` WHERE `user_id`=? AND `questionnaire_id`=? AND `participation_type`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('iii',$playerId,$questionnaireId,$type);

			$set = $statement->execute();

			if($set->getRowCount()>0){
				return true;
			}else{
				return false;
			}
		}

		public function participatesInGroup($playerId , $groupId , $type){
			$query = "SELECT `QuestionnaireParticipation`.`user_id` FROM `QuestionnaireParticipation`
					  INNER JOIN `QuestionGroup` on `QuestionGroup`.`questionnaire_id`=`QuestionnaireParticipation`.`questionnaire_id` 
					  WHERE `QuestionnaireParticipation`.`user_id`=? 
					  AND `QuestionGroup`.`id`=? 
					  AND `QuestionnaireParticipation`.`participation_type`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('iii',$playerId,$groupId,$type);

			$set = $statement->execute();

			if($set->getRowCount()>0){
				return true;
			}else{
				return false;
			}
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
			if( $participation->getParticipationDate() === null ){
				$this->_create($participation);
			}else{
				$this->_update($participation);
			}
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

		private function _update($participation){
			throw new Exception("You cant update a Participation object.");
		}

	}