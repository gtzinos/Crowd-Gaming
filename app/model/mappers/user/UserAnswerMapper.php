<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/Question.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/domain/user/UserAnswer.php';

	class UserAnswerMapper extends DataMapper
	{

		public function findAnswersCountByGroup($questionGroupId ,$userId)
		{
			$query = "SELECT count(*) as counter FROM `UserAnswer` ".
					 "INNER JOIN `Question` ON `Question`.`id`=`UserAnswer`.`question_id` ".
					 "WHERE `Question`.`question_group_id`=? AND `UserAnswer`.`user_id`=?";
					
			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $questionGroupId , $userId);

			$set = $statement->execute();
			
			if($set->next())
			{
				return $set->get("counter");
			}
			return 0;
		}


		public function findAnswersCountByQuestionnaire($questionnaireId ,$userId)
		{
			$query = "SELECT count(*) as counter FROM `UserAnswer` ".
					 "INNER JOIN `Question` ON `Question`.`id`=`UserAnswer`.`question_id` ".
					 "INNER JOIN `QuestionGroup` ON `QuestionGroup`.`id`=`Question`.`question_group_id` ".
					 "WHERE `QuestionGroup`.`questionnaire_id`=? AND `UserAnswer`.`user_id`=?";
					
			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $questionnaireId , $userId);

			$set = $statement->execute();
			
			if($set->next())
			{
				return $set->get("counter");
			}
			return 0;
		}


		/*
			Checks if the user can answer that question 
		 */
		public function canAnswer($questionId , $userId , $groupId)
		{
			/*
				Check if question belongs to questionnaire.
			 */
			$questionMapper = new QuestionMapper;

			

			if( $groupId !==  null )
			{
				$question = $questionMapper->findNextQuestion($userId,$groupId);

				if($question !== null && $question->getId() == $questionId)
					return true;
				else
					return false;
			}
			return false;
		}

		public function findByQuestion($userId, $questionId)
		{
			$query = "SELECT * FROM `UserAnswer` WHERE `user_id`=? AND `question_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $userId , $questionId);

			$set = $statement->execute();

			if($set->next())
			{
				$userAnswer = new UserAnswer;

				$userAnswer->setUserId( $set->get("user_id") );
				$userAnswer->setQuestionId( $set->get("question_id") );
				$userAnswer->setAnswerId( $set->get("answer_id") );
				$userAnswer->setLatitude( $set->get("latitude") );
				$userAnswer->setLongitude( $set->get("longitude") );
				$userAnswer->setAnsweredTime( $set->get("answered_time") );

				return $userAnswer;
			}
			return null;
		}

		public function findByGroup($userId , $groupId)
		{
			$query = "SELECT * FROM `UserAnswer` ".
					 "INNER JOIN `Question` ON `Question`.`id`=`UserAnswer`.`question_id` ".
					 "WHERE `user_id`=? AND `Question`.`question_group_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $userId , $groupId);

			$set = $statement->execute();

			$userAnswers = array();

			while($set->next())
			{
				$userAnswer = new UserAnswer;

				$userAnswer->setUserId( $set->get("user_id") );
				$userAnswer->setQuestionId( $set->get("question_id") );
				$userAnswer->setAnswerId( $set->get("answer_id") );
				$userAnswer->setLatitude( $set->get("latitude") );
				$userAnswer->setLongitude( $set->get("longitude") );
				$userAnswer->setAnsweredTime( $set->get("answered_time") );

				$userAnswers[] = $userAnswer;
			}
			return $userAnswers;
		}

		public function findQuestionnaireScore($userId , $questionnaireId )
		{
			$query ="SELECT
						`Question`.`question_group_id`,
						count(`UserAnswer`.`is_correct`) as correct_answers,
						count(`UserAnswer`.`question_id`) as total_answers,
						sum(`Question`.`multiplier` * `UserAnswer`.`is_correct`) as score,
						sum(`Question`.`multiplier`) as max_score
					FROM `UserAnswer`
					INNER JOIN `Question` ON `Question`.`id`=`UserAnswer`.`question_id`
					INNER JOIN `QuestionGroup` ON `QuestionGroup`.`id`=`Question`.`question_group_id`
					WHERE 
						`UserAnswer`.`user_id`=? AND
					    `QuestionGroup`.`questionnaire_id`=?
					GROUP BY `Question`.`question_group_id`";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',$userId,$questionnaireId);

			$set = $statement->execute();

			$score = array();

			while( $set->next() )
			{
				$arrayItem["group-id"] = $set->get("question_group_id");
				$arrayItem["correct_answers"] = $set->get("correct_answers");
				$arrayItem["total_answer"] = $set->get("total_answers");
				$arrayItem["score"] = $set->get("score");
				$arrayItem["max_score"] = $set->get("max_score");

				$score[] = $arrayItem;
			}

			return $score;
		}

		public function findQuestionGroupScore($userId , $questionGroupId)
		{
			$query ="SELECT
						count(`UserAnswer`.`is_correct`) as correct_answers,
						count(`UserAnswer`.`question_id`) as total_answers,
						sum(`Question`.`multiplier` * `UserAnswer`.`is_correct`) as score,
						sum(`Question`.`multiplier`) as max_score
					FROM `UserAnswer`
					INNER JOIN `Question` ON `Question`.`id`=`UserAnswer`.`question_id`
					WHERE 
						`UserAnswer`.`user_id`=? AND
					    `Question`.`question_group_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',$userId,$questionGroupId);

			$set = $statement->execute();

			if( $set->next() )
			{
				$score["correct_answers"] = $set->get("correct_answers");
				$score["total_answer"] = $set->get("total_answers");
				$score["score"] = $set->get("score");
				$score["max_score"] = $set->get("max_score");

				return $score;
			}

			return $null;
		}

		public function deleteByQuestionnaire($questionnaireId)
		{
			$query = "DELETE `UserAnswer`.* FROM `UserAnswer`
					  INNER JOIN `Question` on `Question`.`id`=UserAnswer`.`question_id`
					  INNER JOIN `QuestionGroup` on `QuestionGroup`.`id`=`Question`.`question_group_id`
					  WHERE `QuestionGroup`.`questionnaire_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionnaireId);

			$statement->executeUpdate();
		}

		public function deleteByGroup($groupId)
		{
			$query = "DELETE `UserAnswer`.* FROM `UserAnswer`
					  INNER JOIN `Question` on `Question`.`id`=`UserAnswer`.`question_id`
					  WHERE `Question`.`id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $groupId);

			$statement->executeUpdate();
		}

		public function deleteByQuestion($questionId)
		{
			$query = "DELETE FROM `UserAnswer` WHERE `question_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionId );

			$statement->executeUpdate();
		}


		public function delete($userAnswer)
		{
			$query = "DELETE FROM `UserAnswer` WHERE `user_id`=? AND `answer_id`=? AND `question_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('iii' , $userAnswer->getUserId() , $userAnswer->getAnswerId() , $userAnswer->getQuestionId() );

			$statement->executeUpdate();
		}

		public function persist($userAnswer)
		{
			$this->_create($userAnswer);
		}

		private function _create($userAnswer)
		{
			$query = "INSERT INTO `UserAnswer`(`user_id`, `answer_id`, `question_id`, `latitude`, `longitude`, `answered_time`,`is_correct` ,`answered_date`) VALUES (?,?,?,?,?,?,?,CURRENT_TIMESTAMP)";

			$statement = $this->getStatement($query);
			$statement->setParameters('iiiddii' ,
				$userAnswer->getUserId(),
				$userAnswer->getAnswerId(),
				$userAnswer->getQuestionId(),
				$userAnswer->getLatitude(),
				$userAnswer->getLongitude(),
				$userAnswer->getAnsweredTime(),
				$userAnswer->getCorrect() );

			$statement->executeUpdate();
		}

	}


	