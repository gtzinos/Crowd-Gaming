<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/Answer.php';

	class AnswerMapper extends DataMapper{

		
		public function findAll(){
			$query = "SELECT * FROM `Answer`";
			$statement = $this->getStatement($query);

			$set = $statement->execute();

			$answers= array();

			while($set->next()){
				$answer = new Answer;

				$answer->setId( $set->get("id") );
				$answer->setQuestionId( $set->get("question_id") );
				$answer->setAnswerText( $set->get("answer") );
				$answer->setDescription( $set->get("description") );
				$answer->setCorrect( $set->get("is_correct") );
				$answer->setCreationDate( $set->get("creation_date") );

				$answers[] = $answer;
			}


			return $answers;
		}

		public function findByQuestion($questionId){
			$query = "SELECT * FROM `Answer` WHERE `question_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionId);

			$set = $statement->execute();

			$answers= array();

			while($set->next()){
				$answer = new Answer;

				$answer->setId( $set->get("id") );
				$answer->setQuestionId( $set->get("question_id") );
				$answer->setAnswerText( $set->get("answer") );
				$answer->setDescription( $set->get("description") );
				$answer->setCorrect( $set->get("is_correct") );
				$answer->setCreationDate( $set->get("creation_date") );

				$answers[] = $answer;
			}

			return $answers;
		}

		public function findById($answerId){
			$query = "SELECT * FROM `Answer` WHERE `id`=?";
			
			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $answerId);

			$set = $statement->execute();

			if($set->next()){
				$answer = new Answer;

				$answer->setId( $set->get("id") );
				$answer->setQuestionId( $set->get("question_id") );
				$answer->setAnswerText( $set->get("answer") );
				$answer->setDescription( $set->get("description") );
				$answer->setCorrect( $set->get("is_correct") );
				$answer->setCreationDate( $set->get("creation_date") );

				return $answer;
			}else
				return null;
		}

		public function answerBelongsToQuestion($answerId , $questionId){
			$query = "SELECT * FROM `Answer` WHERE `id`=? AND `question_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii' ,$answerId , $questionId);

			$set = $statement->execute();

			if($set->getRowCount() >0)
				return true;
			return false;
		}

		public function delete($answer){
			$this->deleteById($answer->getId());
		}

		public function deleteById($answerId){
			$query = "DELETE FROM `Answer` WHERE `id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $answerId);

			$statement->executeUpdate();
		}

		public function deleteByQuestion($questionId){
			$query = "DELETE FROM `Answer` WHERE `question_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionId);

			$statement->executeUpdate();
		}

		public function deleteByGroup($groupId){
			$query = "DELETE `Answer`.* FROM `Answer` 
					  INNER JOIN `Question` on `Question`.`id`=`Answer`.`question_id`
					  WHERE `Question`.`question_group_id`=?";


			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $groupId );

			$statement->executeUpdate();
		}

		public function deleteByQuestionnaire($questionnaireId){
			$query = "DELETE `Answer`.* FROM `Answer` 
					  INNER JOIN `Question` on `Question`.`id`=`Answer`.`question_id`
					  INNER JOIN `QuestionGroup` on `QuestionGroup`.`id`=`Question`.`question_group_id`
					  WHERE `QuestionGroup`.`questionnaire_id`=?";


			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionnaireId );

			$statement->executeUpdate();
		}

		public function persist($answer){
			if( $answer->getId() === null ){
				$this->_create($answer);
			}else{
				$this->_update($answer);
			}
		}

		private function _create($answer){
			$query = "INSERT INTO `Answer`(`question_id`, `answer`, `description`, `is_correct`, `creation_date`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";

			$statement = $this->getStatement($query);

			$statement->setParameters('issi' , 
				$answer->getQuestionId(),
				$answer->getAnswerText(),
				$answer->getDescription(),
				$answer->isCorrect() );

			$statement->executeUpdate();
		}

		private function _update($answer){
			$query = "UPDATE `Answer` SET `question_id`=?,`answer`=?,`description`=?,`is_correct`=? WHERE `id`=?";

			$statement = $this->getStatement($query);

			$statement->setParameters('issii' , 
				$answer->getQuestionId(),
				$answer->getAnswerText(),
				$answer->getDescription(),
				$answer->isCorrect() ,
				$answer->getId() );

			$statement->executeUpdate();
		}

	}