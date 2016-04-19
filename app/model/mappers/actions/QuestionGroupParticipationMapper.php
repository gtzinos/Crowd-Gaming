<?php
	include_once '../app/model/domain/actions/QuestionGroupParticipation.php';

	class QuestionGroupParticipationMapper
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
				$participation->setQuestionnaireId( $set->get("question_group_id") );

				return $participation;
			}
			return null;
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
			$query = "INSERT INTO `QuestionnaireParticipation`(`user_id`, `question_group_id`) VALUES (?,?)";

			$statement = $this->getStatement($query);
			$statement->setParameters('iii',
				$participation->getUserId(),
				$participation->getQuestionGroupId() );

			$statement->executeUpdate();
		}

	}