<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/Question.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';

	class QuestionMapper extends DataMapper{

		
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

		public function findNextQuestion($userId , $groupId){

			$userAnswerMapper = new UserAnswerMapper;

			$questionsAnsweredCount = $userAnswerMapper->findAnswersCountByGroup($groupId,$userId);

			$query = "SELECT `Question`.* FROM `Question` ".
					 "WHERE `Question`.`question_group_id`=? ".
					 "LIMIT ?,1";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',$groupId,$questionsAnsweredCount);

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
			}
			return null;

		}

		public function findGroupIdIfParticipates($questionId , $userId , $participationType , $latitude , $longitude){
			$query = "SELECT `QuestionGroup`.`id` FROM `QuestionGroup` ".
					 "INNER JOIN `Question` on `Question`.`question_group_id`=`QuestionGroup`.`id` ".
					 "INNER JOIN `Questionnaire` on `Questionnaire`.`id`=`QuestionGroup`.`questionnaire_id` ".
					 "INNER JOIN `QuestionnaireParticipation` on `QuestionnaireParticipation`.`questionnaire_id`=`Questionnaire`.`id` ".
					 "WHERE `Question`.`id`=? AND `QuestionnaireParticipation`.`user_id`=? AND `QuestionnaireParticipation`.`participation_type`=? ".
					 "AND `QuestionGroup`.`latitude`-`QuestionGroup`.`latitude_deviation` < ? AND `QuestionGroup`.`latitude`+`QuestionGroup`.`latitude_deviation` > ? " . // Latitude check
					 "AND `QuestionGroup`.`longitude`-`QuestionGroup`.`longitude_deviation` < ? AND `QuestionGroup`.`longitude`+`QuestionGroup`.`longitude_deviation` > ? "; // Longitude Check

			$statement = $this->getStatement($query);
			$statement->setParameters('iiidddd' , $questionId , $userId,$participationType , $latitude , $latitude , $longitude, $longitude);


			$set = $statement->execute();

			if($set->next()){
				return $set->get("id");
			}
			return null;
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

		public function findCountByGroup( $questionGroupId ){
			$query = "SELECT count(*) as counter FROM `Question` WHERE `question_group_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionGroupId);

			$set = $statement->execute();

			if( $set->next() )
				return $set->get("counter");
			return 0;
		}

		public function delete($question){
			$this->deleteById($question->getId());
		}

		public function deleteById($questionId){
			$query = "DELETE FROM `Question` WHERE `id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionId );

			$statement->executeUpdate();
		}

		public function deleteByGroup($groupId){
			$query = "DELETE FROM `Question` WHERE `question_group_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $groupId );

			$statement->executeUpdate();
		}

		public function deleteByQuestionnaire($questionnaireId){
			$query = "DELETE `Question`.* FROM `Question` 
					  INNER JOIN `QuestionGroup` on `QuestionGroup`.`id`=`Question`.`question_group_id`
					  WHERE `QuestionGroup`.`questionnaire_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionnaireId );

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

			$statement->setParameters('isid' , 
				$question->getQuestionGroupId(),
				$question->getQuestionText(),
				$question->getTimeToAnswer(),
				$question->getMultiplier() );

			$statement->executeUpdate();
		}

		private function _update($question){
			$query = "UPDATE `Question` SET `question_group_id`=?,`question`=?,`time_to_answer`=? ,`multiplier`=? WHERE `id`=?";

			$statement = $this->getStatement($query);

			$statement->setParameters('isidi' , 
				$question->getQuestionGroupId(),
				$question->getQuestionText(),
				$question->getTimeToAnswer(),
				$question->getMultiplier(),
				$question->getId() );

			$statement->executeUpdate();
		}

	}