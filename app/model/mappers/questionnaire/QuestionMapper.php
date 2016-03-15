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
				$question->setQuestionGroupId( $set->get("question_group_id") );
				$question->setQuestionText( $set->get("question") );
				$question->setTimeToAnswer( $set->get("time_to_answer") );
				$question->setCreationDate( $set->get("creation_date") );
				$question->setMultiplier( $set->get("multiplier") );

				$questions[] = $question;
			}

			return $questions;
		}

		public function findByQuestionGroup($questionGroupId){
			$query = "SELECT * FROM `Question` WHERE `question_group_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionGroupId);

			$set = $statement->execute();

			$questions= array();

			while($set->next()){
				$question = new Question;

				$question->setId( $set->get("id") );
				$question->setQuestionGroupId( $set->get("question_group_id") );
				$question->setQuestionText( $set->get("question") );
				$question->setTimeToAnswer( $set->get("time_to_answer") );
				$question->setCreationDate( $set->get("creation_date") );
				$question->setMultiplier( $set->get("multiplier") );

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
				$question->setQuestionGroupId( $set->get("question_group_id") );
				$question->setQuestionText( $set->get("question") );
				$question->setTimeToAnswer( $set->get("time_to_answer") );
				$question->setCreationDate( $set->get("creation_date") );
				$question->setMultiplier( $set->get("multiplier") );

				return $question;
			}else
				return null;
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
			$query = "INSERT INTO `Question`(`question_group_id`, `question`, `time_to_answer`, `creation_date` , `multiplier` ) VALUES (?,?,?,CURRENT_TIMESTAMP,?)";

			$statement = $this->getStatement($query);

			$statement->setParameters('isi' , 
				$question->getQuestionGroupId(),
				$question->getQuestionText(),
				$question->getTimeToAnswer(),
				$qustionn->getMultiplier() );

			$statement->executeUpdate();
		}

		private function _update($question){
			$query = "UPDATE `Question` SET `question_group_id`=?,`question`=?,`time_to_answer`=? ,`multiplier`=? WHERE `id`=?";

			$statement = $this->getStatement($query);

			$statement->setParameters('isi' , 
				$question->getQuestionGroupId(),
				$question->getQuestionText(),
				$question->getTimeToAnswer(),
				$question->getMultiplier(),
				$question->getId() );

			$statement->executeUpdate();
		}

	}