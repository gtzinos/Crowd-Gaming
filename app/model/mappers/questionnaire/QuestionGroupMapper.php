<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/QuestionGroup.php';

	class QuestionGroupMapper extends DataMapper{

		public function findAll(){
			$query = "SELECT * FROM `QuestionGroup`";
			$statement = $this->getStatement($query);

			$set = $statement->execute();

			$questionGroups = array();

			while($set->next()){
				$questionGroup = new QuestionGroup;

				$questionGroup->setId( $set->get("id") );
				$questionGroup->setQuestionnaireId( $set->get("questionnaire_id") );
				$questionGroup->setName( $set->get("name") );
				$questionGroup->setDescription( $set->get("description") );
				$questionGroup->setLatitude( $set->get("latitude") );
				$questionGroup->setLongitude( $set->get("longitude") );
				$questionGroup->setLatitudeDeviation( $set->get("latitude_deviation") );
				$questionGroup->setLongitudeDeviation( $set->get("longitude_deviation") );			
				$questionGroup->setCreationDate( $set->get("creation_date") );

				$questionGroups[] = $questionGroup;
			}

			return $questionGroups;
		}

		public function findByQuestionnaire($questionnaireId){
			$query = "SELECT * FROM `QuestionGroup` WHERE `questionnaire_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionnaireId);

			$set = $statement->execute();

			$questionGroups = array();

			while($set->next()){
				$questionGroup = new QuestionGroup;

				$questionGroup->setId( $set->get("id") );
				$questionGroup->setQuestionnaireId( $set->get("questionnaire_id") );
				$questionGroup->setName( $set->get("name") );
				$questionGroup->setDescription( $set->get("description") );
				$questionGroup->setLatitude( $set->get("latitude") );
				$questionGroup->setLongitude( $set->get("longitude") );
				$questionGroup->setLatitudeDeviation( $set->get("latitude_deviation") );
				$questionGroup->setLongitudeDeviation( $set->get("longitude_deviation") );			
				$questionGroup->setCreationDate( $set->get("creation_date") );

				$questionGroups[] = $questionGroup;
			}

			return $questionGroups;
		}

		public function findByQuestionnaireAndId($questionGroupId , $questionnaireId){
			$query = "SELECT * FROM `QuestionGroup` WHERE `id`=? AND `questionnaire_id`=?";
			
			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $questionGroupId , $questionnaireId);

			$set = $statement->execute();

			if($set->next()){
				$questionGroup = new QuestionGroup;

				$questionGroup->setId( $set->get("id") );
				$questionGroup->setQuestionnaireId( $set->get("questionnaire_id") );
				$questionGroup->setName( $set->get("name") );
				$questionGroup->setDescription( $set->get("description") );
				$questionGroup->setLatitude( $set->get("latitude") );
				$questionGroup->setLongitude( $set->get("longitude") );
				$questionGroup->setLatitudeDeviation( $set->get("latitude_deviation") );
				$questionGroup->setLongitudeDeviation( $set->get("longitude_deviation") );			
				$questionGroup->setCreationDate( $set->get("creation_date") );

				return $questionGroup;
			}else
				return null;
		}

		public function findById($questionGroupId){
			$query = "SELECT * FROM `QuestionGroup` WHERE `id`=?";
			
			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionGroupId);

			$set = $statement->execute();

			if($set->next()){
				$questionGroup = new QuestionGroup;

				$questionGroup->setId( $set->get("id") );
				$questionGroup->setQuestionnaireId( $set->get("questionnaire_id") );
				$questionGroup->setName( $set->get("name") );
				$questionGroup->setDescription( $set->get("description") );
				$questionGroup->setLatitude( $set->get("latitude") );
				$questionGroup->setLongitude( $set->get("longitude") );
				$questionGroup->setLatitudeDeviation( $set->get("latitude_deviation") );
				$questionGroup->setLongitudeDeviation( $set->get("longitude_deviation") );			
				$questionGroup->setCreationDate( $set->get("creation_date") );

				return $questionGroup;
			}else
				return null;
		}

		public function verifyLocation($groupId , $latitude , $longitude){
			$query = "SELECT * FROM `QuestionGroup` ".
					 "WHERE `id`=? ".
					 "AND `latitude`-`latitude_deviation` < ? AND `latitude`+`latitude_deviation` > ? " . // Latitude check
					 "AND `longitude`-`longitude_deviation` < ? AND `longitude`+`longitude_deviation` > ? "; // Longitude Check

			$statement = $this->getStatement($query);
			$statement->setParameters("idddd", $groupId , $latitude,$latitude,$longitude,$longitude);

			$set = $statement->execute();

			if($set->getRowCount() >0)
				return true;
			return false;
		}

		public function groupBelongsTo($groupId , $questionnaireId){
			$query  = "SELECT `Questionnaire`.`id` FROM `QuestionGroup` INNER JOIN `Questionnaire` ON `Questionnaire`.`id`=`QuestionGroup`.`questionnaire_id` WHERE `QuestionGroup`.`id`=? AND `QuestionGroup`.`questionnaire_id`=? ";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $groupId , $questionnaireId);
			
			$set = $statement->execute();

			if($set->getRowCount() > 0)
				return true;
			return false;
		}

		public function delete($questionGroup){
			$query = "DELETE FROM `QuestionGroup` WHERE `id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionGroup->getId() );

			$statement->executeUpdate();
		}

		public function persist($questionGroup){
			if( $questionGroup->getId() === null ){
				$this->_create($questionGroup);
			}else{
				$this->_update($questionGroup);
			}
		}

		private function _create($questionGroup){
			$query = "INSERT INTO `QuestionGroup`(`questionnaire_id`, `name`, `description`, `latitude`, `longitude`, `latitude_deviation`, `longitude_deviation`, `creation_date`) VALUES (?,?,?,?,?,?,?,CURRENT_TIMESTAMP)";

			$statement = $this->getStatement($query);

			$statement->setParameters('issdddd' , 
				$questionGroup->getQuestionnaireId(),
				$questionGroup->getName(),
				$questionGroup->getDescription(),
				$questionGroup->getLatitude(),
				$questionGroup->getLongitude(),
				$questionGroup->getLatitudeDeviation(),
				$questionGroup->getLongitudeDeviation() );

			$statement->executeUpdate();
		}

		private function _update($questionGroup){
			$query = "UPDATE `QuestionGroup` SET `questionnaire_id`=?,`name`=?,`description`=?,`latitude`=?,`longitude`=?,`latitude_deviation`=?,`longitude_deviation`=? WHERE `id`=?";

			$statement = $this->getStatement($query);

			$statement->setParameters('issddddi' , 
				$questionGroup->getQuestionnaireId(),
				$questionGroup->getName(),
				$questionGroup->getDescription(),
				$questionGroup->getLatitude(),
				$questionGroup->getLongitude(),
				$questionGroup->getLatitudeDeviation(),
				$questionGroup->getLongitudeDeviation(),
				$questionGroup->getId() );

			$statement->executeUpdate();
		}

	}