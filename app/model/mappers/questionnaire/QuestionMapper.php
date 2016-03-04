<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/Question.php';

	class Question extends DataMapper{

		
		public function findAll(){
			$query = "SELECT * FROM `Question`";
			$statement = $this->getStatement($query);

			$set = $statement->execute();

			$questions= array();

			while($set->next()){
				$question = new Question;

				$question->setId( $set->get("id") );
				$question->setQuestionGroupId( $set->get("qid") );
				$question->setName( $set->get("name") );
				$question->setTimeToAnswer( $set->get("time_to_answer") );
				$question->setCreationDate( $set->get("creation_date") );

				$questions[] = $question;
			}

			return $questions;
		}

		public function findByQuestionGroup($questionGroupId){
			$query = "SELECT * FROM `Question` WHERE `qid`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionGroupId);

			$set = $statement->execute();

			$questions= array();

			while($set->next()){
				$question = new Question;

				$question->setId( $set->get("id") );
				$question->setQuestionGroupId( $set->get("qid") );
				$question->setName( $set->get("name") );
				$question->setTimeToAnswer( $set->get("time_to_answer") );
				$question->setCreationDate( $set->get("creation_date") );

				$questions[] = $question;
			}

			return $questions;
		}

		public function findById($questionId){
			$query = "SELECT * FROM `Question` WHERE `id`=?";
			
			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionId);

			$set = $statement->execute();

			if($set->next()){
				$question = new Question;

				$question->setId( $set->get("id") );
				$question->setQuestionGroupId( $set->get("qid") );
				$question->setName( $set->get("name") );
				$question->setTimeToAnswer( $set->get("time_to_answer") );
				$question->setCreationDate( $set->get("creation_date") );

				return $question;
			}else
				return false;
		}

		public function delete($questionGroup){
			$query = "DELETE FROM `Question` WHERE `id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionGroup->getId() );

			$statement->executeUpdate();
		}

		public function persist($question){
			if( $question->getId() === null ){
				$this->_create($question);
			}else{
				$this->_update($question);
			}
		}

		private function _create($question){
			$query = "INSERT INTO `Question`(`gid`, `question`, `time_to_answer`, `creation_date`) VALUES (?,?,?,CURRENT_TIMESTAMP)";

			$statement = $this->getStatement($query);

			$statement->setParameters('isi' , 
				$question->getQuestionGroupId(),
				$question->getQuestionText(),
				$question->getTimeToAnswer() );

			$statement->executeUpdate();
		}

		private function _update($question){
			$query = "UPDATE `Question` SET `gid`=?,`question`=?,`time_to_answer`=? WHERE `id`=";

			$statement = $this->getStatement($query);

			$statement->setParameters('isi' , 
				$question->getQuestionGroupId(),
				$question->getQuestionText(),
				$question->getTimeToAnswer(),
				$question->getId() );

			$statement->executeUpdate();
		}

	}