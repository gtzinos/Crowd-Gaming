<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/actions/Participation.php';

	class ParticipationMapper extends DataMapper{

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



	}