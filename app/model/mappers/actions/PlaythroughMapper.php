<?php

	include_once '../core/model/DataMapper.php';

	class PlaythroughMapper extends DataMapper
	{

		public function initPlaythrough($user_id , $questionnaire_id)
		{
			$query = "INSERT INTO Playthrough ( user_id , question_group_id )
						SELECT ?, id
						FROM QuestionGroup
						WHERE questionnaire_id=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $user_id,$questionnaire_id);
			$statement->executeUpdate();
		}

		public function deletePlaythrough($user_id , $questionnaire_id)
		{
			$query =   "DELETE Playthrough.* 
						FROM Playthrough
						INNER JOIN QuestionGroup ON QuestionGroup.id=Playthrough.question_group_id
						WHERE QuestionGroup.questionnaire_id=? AND Playthrough.user_id=?";
			
			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $questionnaire_id , $user_id);
			$statement->executeUpdate();
		}

		public function deleteAllPlaythroughs($questionnaire_id)
		{
			$query = "DELETE `Playthrough`.* 
					  FROM `Playthrough`
					  INNER JOIN `QuestionGroup` ON `QuestionGroup`.`id`=`Playthrough`.`question_group_id`
					  WHERE `QuestionGroup`.`questionnaire_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionnaire_id);
			$statement->executeUpdate();
		}

		public function deletePlaythroughByGroup($question_group_id)
		{
			$query = "DELETE FROM `Playthrough` WHERE `question_group_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i', $question_group_id);
			$statement->executeUpdate();
		}

		public function groupLeftWithPriority( $user_id , $questionnaire_id , $priority )
		{
			$query = "SELECT * FROM `QuestionGroup` 
					  INNER JOIN `Playthrough` on `Playthrough`.`question_group_id`=`QuestionGroup`.`id`
					  WHERE `Playthrough`.`completed`=0 AND `Playthrough`.`user_id`=? AND `QuestionGroup`.`questionnaire_id`=?
					  AND `QuestionGroup`.`priority`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters("iii", $user_id , $questionnaire_id , $priority);
			
			$set = $statement->execute();

			if( $set->next() )
				return true;
			return false;
		}

		public function findTimeLeft($user_id , $question_group_id)
		{
			$query =   "SELECT (`QuestionGroup`.`time-to-complete` - TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP, Playthrough.time_started)) ) as time_left
						FROM Playthrough
						INNER JOIN QuestionGroup ON QuestionGroup.id=Playthrough.question_group_id
						WHERE Playthrough.user_id=? AND Playthrough.question_group_id=? AND QuestionGroup.`time-to-complete`>0";
			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $user_id , $question_group_id);

			$set = $statement->execute();

			if($set->next())
				return $set->get("time_left");
			return null;
		}

		public function findRepeatCount($user_id , $question_group_id)
		{
			$query ="SELECT `repeats` FROM `Playthrough` 
					 WHERE `user_id`=? AND `question_group_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii', $user_id , $question_group_id);

			$set = $statement->execute();

			if( $set->next() )
				return $set->get("repeats");
			return 1;
		}

		public function persistRepeatCount($user_id , $question_group_id , $repeats)
		{
			$query = "UPDATE `Playthrough` SET `repeats`=? WHERE `user_id`=? AND `question_group_id`=?";
			
			$statement = $this->getStatement($query);
			$statement->setParameters('iii',$repeats , $user_id , $question_group_id);

			$set = $statement->executeUpdate();
		}

		public function setCompleted($user_id , $question_group_id)
		{
			$query =   "UPDATE Playthrough
						SET completed=1
						WHERE user_id=? AND question_group_id=?";
			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $user_id , $question_group_id);
			$statement->executeUpdate();
		}

		public function hasStarted($user_id , $question_group_id)
		{

			$query = "SELECT `time_started` FROM `Playthrough` WHERE `user_id`=? AND `question_group_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $user_id , $question_group_id);


			$set = $statement->execute();

			
			if($set->next())
				return $set->get("time_started");
			return null;
		}

		public function findActiveGroupCount($user_id , $questionnaire_id)
		{
			$query =   "SELECT count(*) as counter
						FROM Playthrough
						INNER JOIN QuestionGroup on QuestionGroup.id=Playthrough.question_group_id
						WHERE time_started IS NOT NULL AND completed=0 AND
						user_id=? AND questionnaire_id=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $user_id , $questionnaire_id);
			$set = $statement->execute();

			if($set->next())
				return $set->get("counter");
			return 0;
		}

		public function findCurrentPriority($user_id , $questionnaire_id)
		{
			$query = "SELECT COALESCE(max(`priority`),0) as max_priority FROM QuestionGroup
INNER JOIN `Playthrough` ON `Playthrough`.`question_group_id`=`QuestionGroup`.`id`
WHERE `QuestionGroup`.`questionnaire_id`=? AND `Playthrough`.`user_id`=? AND `time_started` IS NOT NULL";

			$statement = $this->getStatement($query);

			$statement->setParameters("ii" , $questionnaire_id  , $user_id );

			$set = $statement->execute();

			if( $set->next() )
				return $set->get("max_priority");
			return 0;
		}

		public function isQuestionnaireCompleted($user_id , $questionnaire_id)
		{
			$query = "SELECT `completed` FROM Playthrough WHERE user_id=? AND question_group_id=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $user_id , $questionnaire_id);

			$set = $statement->execute();

			if($set->next())
				return $set->get("completed");
			return null;
		}


		public function isCompleted($user_id , $question_group_id)
		{
			$query = "SELECT `completed` FROM Playthrough WHERE user_id=? AND question_group_id=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $user_id , $question_group_id);

			$set = $statement->execute();

			if($set->next())
				return $set->get("completed");
			return null;
		}

		public function startQuestionGroup($user_id , $question_group_id)
		{
			$query =   "UPDATE Playthrough
						SET time_started=CURRENT_TIMESTAMP
						WHERE user_id=? AND question_group_id=?";
			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $user_id , $question_group_id);
			$statement->executeUpdate();
		}

		public function resetQuestionGroup($user_id , $question_group_id)
		{
			$query =   "UPDATE Playthrough
						SET time_started=NULL,completed=0
						WHERE user_id=? AND question_group_id=?";
			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $user_id , $question_group_id);
			$statement->executeUpdate();
		}

	}

