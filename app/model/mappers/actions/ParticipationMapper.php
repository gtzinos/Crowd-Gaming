<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/actions/Participation.php';

	class ParticipationMapper extends DataMapper{

		public function playerParticipates($playerId , $questionnaireId){
			$query = "SELECT `user_id` FROM `QuestionnaireParticipation` WHERE `user_id`=? AND `questionnaire_id`=? AND `participation_type`=1";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',$playerId,$questionnaireId);

			$set = $statement->execute();

			if($set->getRowCount()>0){
				return true;
			}else{
				return false;
			}
		}


	}