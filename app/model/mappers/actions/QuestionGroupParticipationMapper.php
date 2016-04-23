<?php
	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/actions/QuestionGroupParticipation.php';

	class QuestionGroupParticipationMapper extends DataMapper
	{


		public function findParticipation($playerId , $groupId )
		{
			$query = "SELECT * FROM `QuestionGroupParticipation` WHERE `user_id`=? AND `question_group_id`=? ";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',$playerId,$groupId);

			$set = $statement->execute();

			if($set->next())
			{
				$participation = new QuestionGroupParticipation;
				$participation->setUserId( $set->get("user_id") );
				$participation->setQuestionGroupId( $set->get("question_group_id") );

				return $participation;
			}
			return null;
		}

		public function findByGroup($groupId)
		{
			$query = "SELECT * FROM `QuestionGroupParticipation` WHERE `question_group_id`=? ";

			$statement = $this->getStatement($query);
			$statement->setParameters('i',$groupId);

			$set = $statement->execute();

			$participations = array();

			while($set->next())
			{
				$participation = new QuestionGroupParticipation;
				$participation->setUserId( $set->get("user_id") );
				$participation->setQuestionGroupId( $set->get("question_group_id") );

				$participations[] = $participation;
			}
			return $participations;
		}

		public function participates($playerId , $groupId )
		{
			$query = "SELECT `user_id` FROM `QuestionGroupParticipation` WHERE `user_id`=? AND `question_group_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',$playerId,$groupId);

			$set = $statement->execute();

			if($set->getRowCount()>0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		public function findCount( $groupId )
		{
			$query = "SELECT count(*) as counter FROM `QuestionGroupParticipation` WHERE `question_group_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i',$groupId);

			$set = $statement->execute();

			if($set->next())
				return $set->get("counter");
			return 0;
		} 


		public function delete($participation)
		{
			$query = "DELETE FROM `QuestionGroupParticipation` WHERE `user_id`=? AND `question_group_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',
				$participation->getUserId(),
				$participation->getQuestionGroupId());

			$statement->executeUpdate();
		}

		public function persist($participation)
		{

			$this->_create($participation);
		}

		private function _create($participation)
		{
			$query = "INSERT INTO `QuestionGroupParticipation`(`question_group_id`, `user_id`) VALUES (?,?)";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',
				$participation->getQuestionGroupId(),
				$participation->getUserId() );

			$statement->executeUpdate();
		}

	}