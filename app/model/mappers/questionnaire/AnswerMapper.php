<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/Answer.php';

	class Answer extends DataMapper{

		
		public function findAll(){
			$query = "SELECT * FROM `Answer`";
			$statement = $this->getStatement($query);

			$set = $statement->execute();

			$answers= array();

			while($set->next()){
				$answer = new Answer;

				$answer->setId( $set->get("id") );
				$answer->setQuestionId( $set->get("qid") );
				$answer->setAnswerText( $set->get("answer") );
				$answer->setDescription( $set->get("description") );
				$answer->setCorrect( $set->get("isCorrect") );
				$answer->setCreationDate( $set->get("creation_date") );

				$answers[] = $answer;
			}

			return $answers;
		}

		public function findByQuestion($questionId){
			$query = "SELECT * FROM `Answer` WHERE `qid`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $answerGroupId);

			$set = $statement->execute();

			$answers= array();

			while($set->next()){
				$answer = new Answer;

				$answer->setId( $set->get("id") );
				$answer->setQuestionId( $set->get("qid") );
				$answer->setAnswerText( $set->get("answer") );
				$answer->setDescription( $set->get("description") );
				$answer->setCorrect( $set->get("isCorrect") );
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
				$answer->setQuestionId( $set->get("qid") );
				$answer->setAnswerText( $set->get("answer") );
				$answer->setDescription( $set->get("description") );
				$answer->setCorrect( $set->get("isCorrect") );
				$answer->setCreationDate( $set->get("creation_date") );

				return $answer;
			}else
				return false;
		}

		public function delete($answer){
			$query = "DELETE FROM `Answer` WHERE `id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $answer->getId() );

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
			$query = "INSERT INTO `Answer`(`qid`, `answer`, `description`, `isCorrect`, `creation_date`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";

			$statement = $this->getStatement($query);

			$statement->setParameters('issi' , 
				$answer->getQuestionId(),
				$answer->getAnswerText(),
				$answer->getDescription(),
				$answer->isCorrect() );

			$statement->executeUpdate();
		}

		private function _update($answer){
			$query = "UUPDATE `Answer` SET `qid`=?,`answer`=?,`description`=?,`isCorrect`=? WHERE `id`=?";

			$statement = $this->getStatement($query);

			$statement->setParameters('isi' , 
				$answer->getQuestionId(),
				$answer->getAnswerText(),
				$answer->getDescription(),
				$answer->isCorrect() ,
				$answer->getId() );

			$statement->executeUpdate();
		}

	}