<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/Question.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';

	class UserAnswerMapper extends DataMapper{

		public function findAnswersCountByGroup($questionGroupId ,$userId){
			$query = "SELECT count(*) as counter FROM `UserAnswer` ".
					 "INNER JOIN `Question` ON `Question`.`id`=`UserAnswer`.`question_id` ".
					 "WHERE `Question`.`question_group_id`=? AND `UserAnswer`.`user_id`=?";
					
			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $questionGroupId , $userId);

			$set = $statement->execute();
			
			if($set->next()){
				return $set->get("counter");
			}
			return 0;
		}

		/*
			.
			.
			.
			.
			.
		 
			Many things to do

			.
			.
			.
			.
			.

		 */

	}


	